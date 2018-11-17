Hands on tutorial instructions part 1
=====================================

If you use Elastica
-------------------
scripts/createSeedIndex.php instantiates ElasticSearchProvider:
 ```php
    $clientProv = new ElasticSearchProvider($app);
```
If you want to use Elastica, change this to ElasticaProvider.

The same happens in public/index.php, if you want to use Elastica, change this too.

In QueryBuilder::clear replace:
```php
            $this->body = [];
            $this->bool = [];
```
by:
```php
    $this->body = new \Elastica\Query();
    $this->bool = new \Elastica\Query\BoolQuery();
```

In QueryBuilder::getBody replace: 
```php
        if (!empty($this->bool)) {
            $this->body['query'] = ['bool' => $this->bool];
        }
```
by:
```php
        if (is_array($this->bool->toArray()))  {
            $this->body->setQuery($this->bool);
        }
```

Solutions for Elastica are in [doc/Solutions Elastica.md](Solutions Elastica.md)

Provide a client
----------------
To use ElasticSearch we need a client object. 
In scripts/createSeedIndex.php this is retrieved from a
ServiceProvider:
```php
 $app = new Application();
 $clientProv = new ElasticSearchProvider($app);
 $client = $clientProv->get();
```

Using a service provider has the advantage
that we can use the client from different places and still
have the code that creates and configures it only once.
ServiceProviders store the injected Application in member variable $app.

If you have chosen to use the ElasticSearch client,
make ElasticSearchProvider::create return a client
for a single host using the host name and port from the configuration.
[documentation and examples](https://www.elastic.co/guide/en/elasticsearch/client/php-api/6.0/_configuration.html)

If you have chosen to use Elastica, make ElasticaProvider::create and return a client
for a single host using the host name and port from the configuration.
[Elastica example](../scripts/elastica.php)

Create an index
---------------
On line 23 of scripts/createSeedIndex.php an index configuration
is retrieved from the application:
```php
    $indexConfig = $app->config['elasticSearch']['indexes'][$indexName];
```
This configuration can be passed directly to the client for creating the index.
Add code below the assignment to actually create the index.<br>
[elasticSearch client](https://www.elastic.co/guide/en/elasticsearch/client/php-api/6.0/_index_management_operations.html)<br>
[Elastica example](../scripts/elastica.php)

Run the script to test it:
```bash
    php createSeedIndex.php
```

You may test the existence of your index by entering an url like this in your browser:
http://localhost:9200/indexName/
(use your own ElasticSearch hostname, port and index name )

Add documents to the index
--------------------------
scripts/createSeedIndex.php uses RestaurantSeeds to obtain some
instances of Entity\Restaurant to seed the index. To do so it 
loops trough the restaurants and uses a normalizer
to convert it to an associative array:
```php
    $data = $restaurantNormalizer->normalize($restaurant, null, $context);
```

This normalizer is a component of the Symfony framework. 
[documentation](https://symfony.com/doc/current/components/serializer.html)
In scripts/createSeedIndex.php you can see how it is instantiated
and configured to recursively normalize the entities. In real life
you will probably need some more configuration in order to avoid
inclusion of properties that would lead to recursion,
see [ignoring attributes](https://symfony.com/doc/current/components/serializer.html#ignoring-attributes)

Add code below the call to the Normalizer that
inserts each $data in the ElasticSearch index.<br>
[elasticSearch client](http://www.elasticsearch.org/guide/en/elasticsearch/client/php-api/6.0/index.html)<br>
[Elastica example](../scripts/elastica.php)
(you don't need to refresh the index)

Run the script again to seed the index.

You may test the existence of your index by entering an url like this in your browser:
http://localhost:9200/indexName/_search
(use your own ElasticSearch hostname, port and index name )


[Continue with part 2](Instructions_2.md)