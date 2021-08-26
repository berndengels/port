#!/bin/sh
group=stuff

sudo chgrp -R $group storage/logs storage/framework storage/app bootstrap/cache database/dumps
sudo chmod -R ugo+rwx storage/logs storage/framework storage/app bootstrap/cache database/dumps
sudo chgrp -R $group .
sudo chmod -R g+rwX .
sudo find . -type d -exec chmod g+s '{}' +
