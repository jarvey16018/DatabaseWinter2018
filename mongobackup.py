import datetime
import shutil
import os
import subprocess
import zipfile


__author__ = 'Matt Swain'
__email__ = 'm.swain@me.com'
__version__ = '1.0'
__license__ = 'BSD'


db = 'ratings'
collections = ['users']
backup_path = '/var/www/DatabaseWinter2018/backups/'
mongoexport_path = '/opt/local/bin/mongoexport'
mongoimport_path = '/opt/local/bin/mongoimport'
max_backups = 10

def compare_zips(file1, file2):
    """ Compare the CRC of the first file in each zip. """
    try:
        z1 = zipfile.ZipFile(file1)
        z2 = zipfile.ZipFile(file2)
    except IOError:
        return False
    crc1 = z1.getinfo(z1.namelist()[0]).CRC
    crc2 = z2.getinfo(z2.namelist()[0]).CRC
    return crc1 == crc2

def run_backup():
    """ Export each collection to a file, hard link duplicates and delete old backups """

    # Set up new backup folder
    now = datetime.datetime.today().strftime('%Y%m%d-%H%M%S')
    this_backup = os.path.join(backup_path, now)
    os.mkdir(this_backup)
    print('Created new backup: %s' % this_backup)

    # Save compressed collections to folder
    for collection in collections:
        print('mongoexport: %s' % collection)
        filepath = os.path.join(this_backup, collection)
        subprocess.call([mongoexport_path, '--db', db, '--collection', collection, '--out', filepath+'.json'], shell=True)
        with zipfile.ZipFile(filepath+'.zip', 'w', zipfile.ZIP_DEFLATED, True) as myzip:
            myzip.write(filepath+'.json',collection+'.json')
        os.remove(filepath+'.json')

        # Check for unchanged collections, and hard link to save space
        for datedir in os.walk(backup_path).next()[1]:
            if not datedir == now:
                oldzip = os.path.join(backup_path, os.path.join(datedir, collection+'.zip'))
                if compare_zips(filepath+'.zip', oldzip):
                    print('Unchanged from %s' % oldzip)
                    os.remove(filepath+'.zip')
                    os.link(oldzip, filepath+'.zip')
                    break

    # Delete old backups when there are more than max
    while len(os.walk(backup_path).next()[1]) > max_backups:
        shutil.rmtree(os.path.join(backup_path, os.walk(backup_path).next()[1][0]))

def restore_backup(collection):
    """ Restore a collection from the latest backup """
    latest_backup = os.path.join(backup_path, os.listdir(backup_path)[-1])
    zippath = os.path.join(latest_backup,'%s.zip' % collection)
    jsonpath = os.path.join(latest_backup,'%s.json' % collection)
    z = zipfile.ZipFile(zippath)
    with open(jsonpath,"w") as jsonfile:
        jsonfile.write(z.read('%s.json' % collection))
    db[collection].rename('%s_old' % collection)
    subprocess.call([mongoimport_path, '--db', dbname, '--collection', collection, jsonpath])
    os.remove(jsonpath)

if __name__ == '__main__':
    run_backup()