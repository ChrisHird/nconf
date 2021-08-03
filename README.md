NConf README
============

**NConf is not dead.** It's just no longer developed by the original developer(s). Here is the most current NConf build updated for current software releases.

NConf homepage:
http://www.nconf.org/

Start guide:
http://www.nconf.org/dokuwiki/doku.php?id=nconf:help:documentation:start:main

Complete documentation:
http://www.nconf.org/dokuwiki/doku.php?id=nconf:help:documentation:detail:main

Table of contents
-----------------
A. Requirements
B. Manual installation
C. Manual update


A. Requirements
---------------

NConf system requirements: (we installed and tested with the following)

    * Apache webserver 2.4.38
    * PHP 7.3, php-mysqli, php-ldap (only if using LDAP auth)
    * MariaDB 10.3.29 (with InnoDB)
    * Perl 5.28, perl-DBI, perl-DBD-MySQL
    * Nagios 4.4.6


php.ini settings:

    * short_open_tag = On
    * register_globals = Off
    * magic_quotes_gpc = Off


Compatibility (older version):
NConf has been tested on Red Hat, Fedora and CentOS Linux.
It has not been tested on Windows or any UNIX, or with SELinux.


Security considerations:
NConf is intended to be deployed within a private network or intranet. As such, development focus is clearly not that of a secure Internet application. Although it can be run anywhere, we do not advise users to publish NConf as a public site.


B. Manual installation
----------------------
The following should be carried out as root
Download the tar.gz file from GitHub and install in the share directory for nagios
```
cd /tmp
mkdir /usr/local/nagios/share/nconf
wget https://github.com/ChrisHird/nconf/archive/sas-master.tar.gz -O nconf.tgz
tar -xf nconf.tgz --directory /usr/local/nagios/share/nconf
chown -R www-data:www-data /usr/local/nagios/share/nconf
chmod  775 /usr/local/nagios/share/nconf/bin/*
```

Create the MySQL database for nconf
```
mysql -u root -p
	CREATE DATABASE nconf;
	CREATE USER nconfadmin@localhost IDENTIFIED BY 'some password of your choice';
	GRANT ALL PRIVILEGES ON nconf.* TO nconfadmin@localhost;
	FLUSH PRIVILEGES;
	exit
```

Create a link to nagios binary for nconf to use
```
ln -s /usr/local/nagios/bin/nagios /usr/local/nagios/share/nconf/bin/nagios
```

Use the Install script for nconf to set up the required configuration and objects
```
http://.../nagios/nconf/INSTALL.php (insert IP address)
```

Once the install script completes you need to edit the nagios config file to allow the nconf changes to be mapped.
```
nano /usr/local/nagios/etc/nagios.cfg
	# added these lines and commented out the others above related to cfg_dir
	cfg_dir=/usr/local/nagios/etc/global
	cfg_dir=/usr/local/nagios/etc/Default_collector
```
Update the deployment file so local deployment can be carried out by NConf
```
nano /usr/local/nagios/share/nconf/config/deployment.ini
	...
	;; LOCAL deployment ;;
	[deploy config]
	type = local
	source_file = "/usr/local/nagios/share/nconf/output/NagiosConfig.tgz"
	target_file = "/usr/local/nagios/etc/"
	action = extract
	reload_command = sudo -u root /bin/systemctl restart nagios
	...
```

For the deployment to work nconf needs to be able to run the reload_command, this requires a change to the sudoers file.
```
visudo
	# added for nconf to allow restart of nagios after deployment
	www-data ALL=NOPASSWD: /bin/systemctl restart nagios
```
Optional: add the images for the OS logos etc.
```
cp -a /usr/local/nagios/share/images/logos /tmp/base
mv /tmp/base /usr/local/nagios/share/images/logos/base
```
Use the test config shipped with nconf to test a deployment, you should see the config successfully deployed.
