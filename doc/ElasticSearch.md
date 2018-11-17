Introduction to ElasticSearch
=============================

ElasticSearch is a search engine written in Java. For use in 
other programming languages it offers a web service. See [this slide](https://image.slidesharecdn.com/presentatielaravelphp-180327070244/95/getting-started-with-laravel-elasticsearch-13-638.jpg?cb=1522171800).

Calls to the API are made through http(s) and are specified in 
the url and in JSON that is sent in the request body.
[Some examples](https://image.slidesharecdn.com/presentatielaravelphp-180327070244/95/getting-started-with-laravel-elasticsearch-14-638.jpg?cb=1522171800) 

We could make these calls directly from PHP (using the curl extension)
but life is easier with an ElasticSearch client. For this tutorial
you may choose between the [standard ElasticSearch client](https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/index.html) or the
[Elastica client](http://elastica.io/) that builds on top of it.

If you like to first read an introduction to ElasticSearch you may read through:
[Document Oriented](https://www.elastic.co/guide/en/elasticsearch/guide/current/_document_oriented.html)
and the follow the links to 'Finding your Feet', 'Indexing Employee Documents',
'Retrieving a Document' and 'Search Lite'.

There is much more to learn about ElasticSearch. This tutorial will refer to those pages you 
need to read for each step in completing the application. But to write a real-life application
you will need to find your own way in the [Elasticsearch Reference](https://www.elastic.co/guide/en/elasticsearch/reference/current/index.html).


[Continue to Installation](Installation.md)
