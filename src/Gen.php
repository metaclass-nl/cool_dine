<?php

class Gen
{

    static function show($something, $maxDepth=1)
    {
        print "<pre>";
        print "\n\n##################################\n";
        print_r($something);
        //print json_encode($something, JSON_PRETTY_PRINT, $maxDepth);
        print "\n##################################\n";
        print "</pre>\n";
        return $something;
    }


}