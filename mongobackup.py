import shutil
import time
timestr = time.strftime("%Y%m%d-%H%M%S")
shutil.copytree('/var/lib/mongodb', '/var/www/DatabaseWinter2018/backups'+timestr)

