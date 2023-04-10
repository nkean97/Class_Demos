#!/bin/bash
#amazon-linux-extras install epel -y
dnf install -y httpd php stress git
dnf update -y --security
cd
git clone https://github.com/nkean97/Class_Demos.git
cp ./Class_Demos/EC2/* /var/www/html
mv /var/www/html/htaccess /var/www/html/.htaccess
systemctl enable httpd.service
systemctl start httpd.service
echo "Healthy" > /var/www/html/health.html
dnf update -y
