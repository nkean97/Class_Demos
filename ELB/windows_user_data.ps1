<#
Example of user data for EC2 windows instanced
#>

<powershell>

Install-WindowsFeature -name Web-Server -IncludeManagementTools

Import-module AWSPowerShell

Soutput = "c:\inetpub\wwwroot\testwebsite.zip"

Seiest = "c:\inetpub\wwwroot"

copy-s3object -bucketname cjwebby -key testwebsite.zip -LocalFolder Sdest
Expand-Archive Soutput -Destinationpath Sdest

Remove-Item -path c:\inetpub\wwwroot\* -include start.*

Remove-Item -path c:\inetpub\wwwroot\testwebsite.zip

#Restarts the System Management agent service (adds to System Manger)
Restart-Service AWSSSMARent

</powershell>

