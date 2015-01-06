Features
========
* Managing Asterisk realtime SIP peers, stored in MySQL;
* Provisioning Cisco/Linksys IP phones: Cisco SPA504g etc;
* Provisioning Linphone softphones (experimental).


Installation
============
* Setup Asterisk to store realtime SIP peers in MySQL DB
TODO

* Create MySQL database and apply scheme
TODO

* Grant MySQL access
mysqladmin ...

* Grant AMI access
Usually in /etc/asterisk/manager.conf
```
[panel]
secret = AMIPASS
deny = 0.0.0.0/0.0.0.0
permit = 127.0.0.1
read = all,system,call,agent
write = all
```

* Install Smarty library
```
wget -O Smarty-stable.tar.gz http://www.smarty.net/files/Smarty-stable.tar.gz
tar xf Smarty-stable.tar.gz
mv Smarty-*/libs .
rm -r Smarty-*
```

* Correct file owners and permissions
```
chown -R www-data .
chmod 240 logs/auth.log
```

* Customize configs/app.conf

* Customize these files if needed:
static/favicon.ico
templates/email.tpl
.htaccess
locations.php
