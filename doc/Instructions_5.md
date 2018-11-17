Hands on tutorial instructions part 5
=====================================

Query for the number of results when deselecting an option
----------------------------------------------------------
For filter options that are not selected the search page shows how many
restaurants will be found if the user selects that option. Currently
it does the same for filter options that are selected. Of course that
number is always the same as the actual number of results. Let's make
it more informative by showing how many restaurants will be found if the 
user UNSELECTS that option.

It is possible to retrieve that in the same query, but that will make our
QueryBuilder more complex. It is simpler to run through the selected 
filter options and generate a query for each without that option selected,
then execute it for getting a count. Because ElasticSearch caches filters
those queries will be fast enough if we are not processing high volumes.

Complete the method ::retrieveDeactivationCounts. Make it loop 
through the criteria. It the criterium field is an option field,
i.e. it is in $this->app->config['option_fields'],
loop through the selected options.
For each of them make a copy of the criteria by assigning them to a variable.
Then remove the option from the copy.
Create a $body using $this->queryBuilder but without calling ::addAggregations.
Execute the query like it is done in ::searchAction, but use ::count instead of ::search.
Retrieve the count from the result and add it to $deactivationCounts 
under keys $field and $option.

Check the resulting $deactivationCounts with a unit test or a temporary var dump

Process the number of results for when deselecting an option
------------------------------------------------------------
In instruction .. you have implemented ResultTransformer::transformBuckets
ignoring the $deactivationCounts parameter. In order to show how many restaurants 
will be found if the user UNSELECTS an option, inside the loop check
the $deactivationCounts for the $field and each bucket key. If it is set, use
the count from the $deactivationCounts instead of the one from the bucket,
and remove the count from $deactivationCounts.

Finally there may still be options in the criteria that where selected, but that are no 
longer in the aggregations (for example because the user entered a search term).
These criteria typically lead to 0 search results, so the user may want to 
unselect them. 

Because we removed the options from $deactivationCounts while 
processing the aggregations, at the end of the method $deactivationCounts 
for the current $field only holds those counts that are not in the aggregations. 
In order to show them, before returning the results add another entry for each 
remaining option in $deactivationCounts for the current $field. 

If your solution works, the search page should show how many restaurants 
will be found if the user UNSELECTS an option. If you search for a word
that is not found, the selected options should still be visible.


Congratulations! You have completed the tutorial.
[back to the readme](../README.md)