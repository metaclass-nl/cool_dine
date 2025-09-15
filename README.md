This repositry is not maintained.

Hands On tutorial ElasticSearch from PHP
========================================

Cool Dine
---------
ElasticSearch provides a very powerful search engine and a simple PHP client,
but the documentation on practical use in PHP is limited. In his talk on the
Laravel Meetup Groningen Peter Steenbergen filled the gap: He explained the 
internals of the search and filtering page of shop application in PHP 
using Laravel and Vue.js. 

This hands-on tutorial provides skeleton and instructions for building such a page 
yourself. To reach an audience as large as possible it works without 
application frameworks, just PHP, HTML, CSS and a little bit of Javascript. 
Instead of a shop it results in a restaurant search page that includes 
filtering by geograpical location as well as by features and price.

<a href="http://metaclass.nl/dummy/cool_dine.html" title="Page dummy"><img src="http://metaclass.nl/dummy/cool_dine50.png" style="border: 1px solid black"></a>

DOCUMENTATION
-------------
You are advised to read the documentation and follow instruction in the following order:
- [Introduction to ElasticSearch](doc/ElasticSearch.md)
- [Installation and configuration](doc/Installation.md)
- (optional) [Introduction to the application](doc/Application.md) to find your way in this skeleton
- [Instructions part 1](doc/Instructions_1.md) for the hands-on
- [Instructions part 2](doc/Instructions_2.md) 
- [Instructions part 3](doc/Instructions_3.md) 
- [Instructions part 4](doc/Instructions_4.md) 
- [Instructions part 5](doc/Instructions_5.md)
To check your solutions you may compare them with those in: 
- [Solutions for the ElasticSearch client](doc/Solutions ElasticSearch client.md)
- [Solutions for Elastica](doc/Solutions Elastica.md)

FEATURES
--------
- simple PHP application requires no prior knowledge of application 
  or front end frameworks 
- uses elasticsearch PHP client but includes hints on Elastica library 
- creates ElasticSearch index and mapping using language-specific (dutch) analyzers,
- normalizes entities and insert them in the index,
- search using multi_match
- filter using terms, range and geographical distance
- global, bucket end stats aggregations
- follows [design patterns](https://en.wikipedia.org/wiki/Design_pattern_(computer_science)): 
  builder, service provider, entity, valueobject and dependency injection 

REQUIREMENTS
------------
- PHP >=7.0,
- ElasticSearch (link to installation instructions included)
- basic knowledge of PHP, git and composer
- a Web Browser (uses a little bit of javascript and jquery)

Tested with PHP 7.0 and ElasticSearch 6.4.0

LIMITATIONS
----------
- Just a single page, therefore no routing
- All services are only provided once, therefore no service container
- No unit tests, building unit tests is not part of the tutorial
- Not fully [SOLID](https://en.wikipedia.org/wiki/SOLID_(object-oriented_design)):
  . view 'Rendering' inlined in AbstractController, should have a seperate class
- Security: not all input is fully validated
- The Solutions for Elastica are not tested 

RELEASE NOTES
-------------

This is a pre-release version under development. 

COPYRIGHT, LICENCE AND DISCLAIMER
---------------------------------

The code in this bundle was based on [CoolShop from Peter Steenbergen](https://github.com/petericebear/coolshop)
Modifications and additions are Copyricht (c) MetaClass, Groningen, 2018. All rights reserved.

This bundle is under the MIT license. See [the complete license](meta/LICENSE) in the bundle


THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
