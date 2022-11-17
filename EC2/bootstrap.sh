#!/bin/bash
yum install -y httpd php git
service httpd start
cd
git clone https://github.com/nkean97/Class_Demos.git
cp ./Class_Demos/EC2/* /var/www/html
mv /var/www/html/htaccess /var/www/html/.htaccess
echo "Healthy" > /var/www/html/health.html
yum update -y
