Installation and configuration
==============================

Requirements
------------
You need PHP >= 7.0, see [Installing PHP](PHP.md).

And you need basic knowledge of programming in PHP. You may search the web for 'php tutorial' 
to find a tutorial (the one from php.net is definitely too short). If you like learning
from video you could try [The PHP Practitioner](https://laracasts.com/series/php-for-beginners).

Install the skeleton application
--------------------------------

With git from git bash (windows) or the command line (See [Git downloads](https://git-scm.com/downloads) on how to install git):
```bash
   git clone https://github.com/petericebear/coolshop.git
```
This is preferred for GroningenPHP. 

Alternatively you may [download the zip file](https://github.com/petericebear/coolshop/archive/master.zip) 
and unpack it manually.

Choose your php library 
-----------------------

The hands on can be built using the standard ElasticSearch client.

The Elastica library provides on top of the standard ElasticSearch client
a set of classes for accessing ElasticSearch and generating queries.
The query classes help you to structure your queries and offer an API 
in PHP so that your IDE can suggest completion while you are typing.

However, the ElasticSearch client is more one-to-one with the 
documentation on elastic.co that we will refer to, so guess it
has a somewhat lower learning curve. Currently solutions for
the Instructions for Elastica are not fully and not tested.

If you want to use Elastica, in composer.json move 
```json
    "ruflin/elastica": "^6.0"
```
from "suggest" to "require".

Install the dependencies
------------------------
In the root folder of the skeleton:
```bash
    php composer.phar install
```
(for windows you may have to use git bash as composer may use git too)

Configure your webserver
------------------------

To test the application you need an HTTP server with PHP. You may
install it somewhere where your existing development server can access it,
then add a virtual host to its configuration using the 'public' folder 
of the skeleton as its www root folder.

Or you may use PHP as your webserver:
```bash
   php -S localhost:8080 -t ./public
```

Or you may upload the application to a web hosting account, 
but then you have to upload every change 
you make before you can test it.

Test your installation so far
-----------------------------
Browse index.php in the public folder. If you use PHP as your web server
go to [http://localhost:8080/test.php](http://localhost:8080/test.php).

Install Elasticsearch
---------------------

See [Installing Elasticsearch on elastic.co](https://www.elastic.co/guide/en/elasticsearch/reference/current/install-elasticsearch.html)
You first need to install a jre otherwise you may get an error like 
"subprocess new pre-installation script returned error exit status 1"

Test Elasticsearch
------------------
Browse the ip address or hostname and port number of ElasticSearch.
For a default local installation this is [http://localhost:9200/](http://localhost:9200/)
You should get a json response including:
    "tagline" : "You Know, for Search"

Configure the application
-------------------------
Copy file config/parameters.dist.php to parameters.php.

Enter the ip address or hostname and port of your ElasticSearch
into config/parameters.php
For a default local installation the host is localhost and the port is 9200


[Continue to the introduction to the application](Application.md)
or [Go straight to the hands on instruction part 1](Instructions_1.md)