#!/bin/sh
mkdir apache_conf
cd apache_conf/
tar -zxvf ../http_secure.tar.gz
sudo cp -T -R -v etc /etc
sudo cp mod_security2.so /usr/lib64/httpd/modules/
sudo service httpd restart
