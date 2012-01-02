#!/bin/bash 
#
# helper script to deploy origin/master to remote server
#

GIT_PARAMS="--format=tar"
GIT_BRANCH="origin/master"

SSH_CMD="ssh -p 666 root@cmt2.sp0t.de"
SSH_DIR="/home/norman/htdocs/livesets.de"


git archive ${GIT_PARAMS} ${GIT_BRANCH} | gzip -9c | ${SSH_CMD} "cd ${SSH_DIR}; tar xvzf -;./bin/deployed.sh"



#
BASEDIR=$(pwd)

# set user, group and permissions 
chown -R norman:www-data $BASEDIR 
chmod -R 775 $BASEDIR 

# set extra permissions to cache/ and log/ dirs
chmod -R 777 $BASEDIR/cache $BASEDIR/logs 

# touch testfile
touch $BASEDIR/.deployed

