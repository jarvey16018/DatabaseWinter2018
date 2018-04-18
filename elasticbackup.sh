#!/bin/bash

################################################################
#####  script to backup lucene index from elastic search    ####
################################################################

# Shamelessly copied from https://gist.github.com/nherment/1939828

NOW=`date +%Y%m%d%H%M%S`

BACKUP_LOCATION=/var/www/DatabaseWinter2018/backups

esHost=localhost
esPort=9200
defaultIndex=calendar
indexLocation=/var/lib/elasticsearch/
logdir=/var/log/elasticsearch
index=$1

# Days to keep old backups
days=3

################################################################################
# Utility functions
################################################################################

printlog()
{
  MESSAGE=$1
  shift;
  # -e enables interpretation of backslash-escaped characters
  # use with \c to suppress newlines.
  echo -e ${MESSAGE} >> ${logdir}/backup-${NOW}.log
}

try()
{
  # Red & green
  failed=$(printf "\033[0;31m%s" "failed."; printf "\033[0m")
  success=$(printf "\033[0;32m%s" "success."; printf "\033[0m")

  # This is probably good for one-liners, but not much else.
  printlog "$*"
  eval "$*" >> ${logdir}/backup-${NOW}.log 2>&1
  if [ $? -gt 0 ]; then
    printlog $failed
  else
    printlog $success
  fi
}

findlv()
{
  p=$1
  shift;
  res=$(df -P $p | tail -1 | cut -d ' ' -f 1)
  res=$(lvs --noheadings -o lv_name $res 2> /dev/null)
  res=${res%\\n}
  echo $res
}

findvg()
{
  p=$1
  shift;
  res=$(df -P $p | tail -1 | cut -d ' ' -f 1)
  res=$(lvs --noheadings -o vg_name $res 2> /dev/null)
  res=${res%\\n}
  echo $res
}

vgfree()
{
  p=$1
  shift;
  res=$(vgs --units b --nosuffix --noheadings -o vg_free $p 2> /dev/null)
  res=${res%\\n}
  echo $res
}

vgreserve()
{
  # Ten percent of the volume group; must be in KB or a multiple of 512B.
  p=$1
  shift;
  res=$(vgs --units b --nosuffix --noheadings -o vg_size $p 2> /dev/null)
  res=${res%\\n}
  res=$[$[res / 10] / 1024]
  echo $res
}

adjust_thresholds()
{
  t_ops=$1; shift;
  t_size=$1; shift;
  t_size=$1; shift;

  printlog "Adjusting threshold settings"
  msg=`curl -XPUT -s "http://$esHost:$esPort/$index/_settings" -d '
  {
    "index": {
      "translog": {
        "flush_threshold_ops": "'$t_ops'",
        "flush_threshold_size": "'$t_size'",
        "flush_threshold_period": "'$t_per'" 
      }
    }
  }'`
  printlog $msg
}

################################################################################
printlog "Starting backup"
if [ x$index == x ]; then
  printlog "No index specified, using default of calendar"
  index=$defaultIndex
fi

################################################################################
printlog "Retrieving settings for index: $index"
try curl -XGET -s -o /tmp/$index-settings "http://$esHost:$esPort/$index/_settings?pretty=true"
# Modify the first and last two lines of the resulting data
sed -i -e '1,2d' /tmp/$index-settings
sed -i -e '$d' /tmp/$index-settings
sed -i -e '$d' /tmp/$index-settings
sed -i -e '1i\
{' /tmp/$index-settings
sed -i -e '$s/$/,/' /tmp/$index-settings


################################################################################
printlog "Changing threshold settings for index: $index"
printlog ""
adjust_thresholds 50000 50000 600

################################################################################
printlog 'Flushing '
msg=`curl -XPOST -s "http://$esHost:$esPort/_flush"`

printlog $msg
printlog 'Pausing to allow flush to complete'
sleep 90

################################################################################
printlog "Retrieving index mapping: $index"
try curl -XGET -s -o /tmp/$index-mapping "http://$esHost:$esPort/$index/_mapping?pretty=true"
# Modify the first and last two lines of the resulting data
sed -i -e '1,2d' /tmp/$index-mapping
sed -i -e '1i\
  "mappings" : {' /tmp/$index-mapping
sed -i -e '$d' /tmp/$index-mapping
sed -i -e '$a\
}' /tmp/$index-mapping

# Create the final json doc that creates the index.
cat /tmp/$index-settings /tmp/$index-mapping > /tmp/create-$index.json

################################################################################
printlog "Creating restore script for $index"
cat << EOF >> /tmp/$index-restore.sh
#!/bin/bash
#
# This script requires $index.tar.gz and will restore it into elasticsearch
# it is ESSENTIAL that the index you are restoring does NOT exist in ES. delete it
# if it does BEFORE trying to restore data.
wd=\`dirname \$0\`
# create index and mapping
echo -n "Creating index and mappings..."
curl -XPUT -s 'http://$esHost:$esPort/$index/' -d '
`cat /tmp/create-$index.json`
' > /dev/null 2>&1
echo "DONE!"
# extract our data files into place
echo -n "Restoring index (this may take a while)..."
tar xzf \$wd/$index.$NOW.tar.gz -C $indexLocation
chown -R elasticsearch:elasticsearch $indexLocation
echo "DONE!"
# restart ES to allow it to open the new dir and file data
echo -n "Restarting Elasticsearch..."
/etc/init.d/elasticsearch restart
echo "DONE!"
EOF

chmod 755 /tmp/$index-restore.sh

################################################################################
printlog "Adding metadata to ${BACKUP_LOCATION}/${index}.$NOW.tar"
cd /tmp
try tar -cPf ${BACKUP_LOCATION}/${index}.${NOW}.tar create-$index.json $index-restore.sh

################################################################################
# Create LVM snapshot if there is 10% of the index volume free in its volume group.

volgroup=$(findvg $indexLocation)
logvol=$(findlv $indexLocation)
freespace=$(vgfree $volgroup)
snapsize=$(vgreserve $volgroup)

snapmounted=0
if [ $freespace -gt $snapsize ]; then
  printlog "Creating LVM snapshot of $indexLocation"
  try mkdir /tmp/snapshot-${NOW}
  try /usr/sbin/lvcreate -L${snapsize}k -s -n snap-${NOW} /dev/${volgroup}/${logvol}
  try mount /dev/${volgroup}/snap-${NOW} /tmp/snapshot-${NOW}
  if [ $? -eq 0 ]; then
    indexLocation=/tmp/snapshot-${NOW}
    adjust_thresholds 500 500 60
    snapmounted=1
  fi
fi

################################################################################
printlog "Backing up $index"

pushd $indexLocation 
try tar -rPf ${BACKUP_LOCATION}/${index}.${NOW}.tar default/nodes/0/indices/$index
popd

printlog "Compressing ${BACKUP_LOCATION}/${index}.$NOW.tar"
try gzip -6 ${BACKUP_LOCATION}/${index}.${NOW}.tar 

################################################################################
printlog "Cleaning up temporary files."
try rm /tmp/create-$index.json /tmp/$index-restore.sh /tmp/$index-settings /tmp/$index-mapping

################################################################################
# Unmount snapshot LV or adjust flush thresholds back to sane.

if [ $snapmounted -eq 1 ]; then
  printlog "Unmounting LVM snapshot /tmp/snapshot-${NOW}"
  try umount /tmp/snapshot-${NOW}
  try /usr/sbin/lvremove -f /dev/${volgroup}/snap-${NOW}
  if [ $? -eq 0 ]; then
    rmdir /tmp/snapshot-${NOW}
  else
    printlog "Check for orphaned LVM snapshots!"
  fi
else
  # This has already been done if the snapshot was created
  adjust_thresholds 500 500 60
fi

printlog "Done."