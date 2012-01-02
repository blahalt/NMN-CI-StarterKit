#!/bin/bash 
#
# maintenance script runs after deployment to fix permissions and more.
#
#
BASEDIR=$(pwd)

# set user, group and permissions 
chown -R norman:www-data $BASEDIR 
chmod -R 775 $BASEDIR 

# set extra permissions to cache/ and log/ dirs
chmod -R 777 $BASEDIR/cache $BASEDIR/log 



