#!/bin/bash
dnf install -y httpd php stress git
dnf update -y --security
systemctl enable httpd.service
systemctl start httpd.service
cd
git clone https://github.com/nkean97/Class_Demos.git
cp ./Class_Demos/EC2/* /var/www/html
mv /var/www/html/htaccess /var/www/html/.htaccess
echo "Healthy" > /var/www/html/health.html
dnf update -y