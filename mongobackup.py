import os
import os.path
import shutil
import fnmatch
list_of_dirs_to_copy = ['/var/lib/mongodb'] # List of source dirs
dest_dir = '/var/www/DatabaseWinter2018/backups'     # folder for the destination of the copy
files_patterns = ['*.txt', '*.doc']
for root_path in list_of_dirs_to_copy:
    for root, dirs, files in os.walk(root_path): # recurse walking
        for dir in excluded_subdirs:
            if dir in dirs:
                dirs.remove(dir)   # remove the dir from the subdirs to visit
        if not os.path.exists(dest_dir):
            os.makedirs(dest_dir)  # create the dir if not exists
        for pattern in files_patterns:
            for thefile in fnmatch.filter(files, pattern):  # filter the files to copy
                shutil.copy2(os.path.join(root, thefile), dest_dir) #copy file