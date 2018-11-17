Introduction to the application
===============================

In the hands on part of this turorial you will complete
the simple application 'Cool Dine' for searching and
filtering restaurants with ElasticSearch. It consists
of only a single page, whose layout is already included
in the skeleton application. 

The skeleton application does not use an application framework, 
template engine or front end framework. Instead it is built
directly in PHP and some HTML, CSS, Javascript and Jquery. 
Not because that is better practice, but because applications using 
a framework are hard to understand if you don't know the framework. 
This way everyone who knows PHP can follow along with the tutorial.

But even in a simple application like 'Cool Dine' design patterns can be 
applied and reusable code can be factored out. The most generic
classes are in the src/App/Generic folder: 
- AbstractApplication represents an application and takes care
  of the configuration, which is included from the config folder,
- AbstractServiceProvider allows to create services in a
  consistent way,
- AbstractController offers generic Controller functions, in this
  case rendering a page using a layout.

The application only has a single page so there is no router.
The Controller is simply instantiated in public/index.php.
Take a look at this file. Here you can see how dependency 
injection takes place:
```php
// Create dependencies to be injected
$app = new Application();
$clientProv = new ElasticSearchProvider($app);
$transformerProv = new ResultTransformerProvider($app);
$indexName = $app->config['param']['elasticSearch']['index'];
$queryBuilder = new QueryBuilder($app, $indexName, 'Restaurant');

// Create controller
$controller = new SearchController(
    $app,
    $clientProv->get(),
    $queryBuilder,
    $transformerProv->get('Restaurant')
);
```

Take a look at the ResultTransformerProvider. It implements a 
function ::create which instantiates a ResultTransformer service  
supplying some configuration that was made in config/elasticSearch.php.:
```php
    /**
     * {@inheritdoc}
     * @param $args array(entityName)
     */
    protected function create($args)
    {
        return new ResultTransformer($this->app->config['elasticSearch']['classes'][$args[0]]);;
    }
```
The configuration comes from the array under 'classes':
```php
    return [
        'indexes' => [
           (...)
        ],
        'classes' => [
            'Restaurant' => [
                (...)
            ],
        ],
    ];
```

Which class configuration is used depends on the first argument supplied to the ::get method.
In public/index.php you can see the resulting Transformer is passed
to the Controllers constructor as the 4th argument and there 'Restaurant' 
is passed to ::get:
```php
    $transformerProv->get('Restaurant')
```
This way the ResultTransformer can be used for other classes as well, 
assuming you make the proper configuration for each class in 
config/elasticSearch.php.

QueryBuilder is not a service because its state holds processing values.
If the same QueryBuilder instance would be used in several places, one place might
change the state of the instance, thereby implicitly changing the results for the other place too.  
Therefore it is instantiated directly in index.php. 

Finally public/index.php calls ::searchAction on the SearchController.
This method first retrieves data sent by the search form from $_REQUEST:
```php
        $searchText = isset($_REQUEST['search_text']) ? $_REQUEST['search_text'] : null;
        $criteria = isset($_REQUEST['criteria']) ? $_REQUEST['criteria'] : [];
        $coordinates = isset($_REQUEST['coordinates']) ? $_REQUEST['coordinates'] : null;
        $distance = isset($_REQUEST['distance']) ? $_REQUEST['distance'] : null;
```

In the middle of ::searchAction a lot is happening with ElasticSearch. This is the core of
this tutorial and will be explained later on in the hands-on Instructions.

Finally ::renderPage is called to render the page and sends it back to 
the browser:
```php
    $this->renderPage('search/main', $viewParams);
```
::renderPage includes files from the resources/view folder,
starting with layout.php, which then includes the specified view
file, in this case resources/view/search/main.php. 

You may browse the view files yourself. They mainly contain HTML
but at specific places data from php is inserted using <?= tags:
```php
    <title><?= htmlspecialchars($title) ?></title>
```
Here everything from `<`?= through ?`>` gets replaced by the output of the htmlspecialchars 
function. This function converts ordinary text into HTML by replacing 
some special characters like <, > end " so that the browser will correctly 
show those characters instead of starting a tag or ending a parameter value.
This also is a security measure to avoid [cross site scripting](https://www.owasp.org/index.php/Cross-site_Scripting_(XSS))

The view files are kept readable by decomposition into more files:
```php
                    <?php
                        foreach ($data as $item) {
                            include 'search-result.php';
                        }
                    ?>
```
This way you can see right away where the loop ends.

Go on to the [Instructions part 1](Instructions_1.md) 
for the hands-on tutorial. 