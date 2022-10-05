#!/bin/bash
yum update -y --security
amazon-linux-extras install epel -y
yum -y install httpd php stress git
systemctl enable httpd.service
systemctl start httpd.service
cd
git clone https://github.com/nkean97/Class_Demos.git
cp -r ./Class_Demos/CloudWatch/* /var/www/html
