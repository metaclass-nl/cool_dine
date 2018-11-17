<?php

$parameters = require ('parameters.php');
return [
    'param' => $parameters,
    'elasticSearch' => require ('elasticSearch.php'),
    'locale' => 'nl-NL',
];