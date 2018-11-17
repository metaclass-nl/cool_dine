Installing PHP
==============

If you have followed a tutorial on PHP you probably have
already installed PHP. To find out your PHP version enter on a command prompt:
```bash
    php -v
```

But just in case you don't have PHP installed yet:

For windows see [windows.php.net](https://windows.php.net/download/).
In case you get an error message about a missing extension 
you may enable it in php.ini.

For Mac OS X see [Installation on macOS](https://secure.php.net/manual/en/install.macosx.php)

For CentOS linux 7 you may take a look at [tecmint.com](https://www.tecmint.com/install-php-7-in-centos-7/)

For ubuntu linux 16.4 and up enter:

```bash
    sudo apt-get install php
    sudo apt-get install php-curl
```
This may also work for other debian-based linux versions, but 
the version of PHP you get depends on the distribution and
its version. If you get an older version of PHP, search the web for 
PHP 7 and the name your linux distribution.  

In case you get an error message about a missing extension 
you may install it like this: 
apt-get install php-xml
apt-get install php-intl
apt-get install php-gd
apt-get install php-mbstring


