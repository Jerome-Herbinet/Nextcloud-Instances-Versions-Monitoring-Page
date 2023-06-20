# A simple Nextcloud Instances Versions Monitoring Page

## Description : 
Simple page for displaying and tracking versions of several Nextcloud instances.
Used languages will be : PHP HTML CSS JAVASCRIPT JQUERY
This program fetches the Nextcloud status.php content and compares it with Nextcloud versions and their EOL dates, stored in an array in the php file.

[Capture vidéo du 2023-06-19 21-52-50.webm](https://github.com/Jerome-Herbinet/Nextcloud-Instances-Versions-Monitoring-Page/assets/33763786/9ab08e85-68cd-41f8-ae0a-14ed5faf96ef)

## Restrictions : 
This program does not work : 
- with "hidden" Nextcloud instances (and therefore only accessible via a VPN, for example)
- with Nextcloud instances whose access to status.php has been blocked.
- with Owncloud instances (may work partially because of a small field label difference in the status.php file). See developpment roadmap.

## Installation : 
1. Upload all the files behind a regular web environment and "https://..." URL. All is static, so you don't need any database.
2. Inside the index.php file, fill out the Nextcloud instances domains list and the additionnal major Nextcloud version + EOL date, if missing. You can also change wordings with better ones or you can simply translate them.

## Developpent roadmap : 
- Better UI
- Responsive design
- Owncloud compatibility
