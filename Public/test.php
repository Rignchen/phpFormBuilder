<?php
session_start();
require_once '../vendor/autoload.php';

// this is the 1st test I've done, it doesn't work as I wanted, but I want to keep a trace of it
$toto = [];
$toto[0][] = "toto";
$toto[0][] = "toto2";
$toto[3][] = "3toto";
$toto[0][] = "toto3";
$toto[3][] = "3toto2";
$toto[2][] = "2toto";
dump ($toto); // [0 => ["toto", "toto2", "toto3"], 3 => ["3toto", "3toto2"], 2 => ["2toto"]] <- I thought it would have been ordered by array key

// this is the 2nd test I've done which this time works as I wanted
$test = [[],[],[],[],[]];
$test[0][] = "test";
$test[0][] = "test2";
$test[3][] = "3test";
$test[0][] = "test3";
$test[3][] = "3test2";
$test[2][] = "2test";
dump($test); // [0 => ["test", "test2", "test3"], 1 => [], 2 => ["2test"], 3 => ["3test", "3test2"], 4 => []]
