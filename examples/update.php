<?php

require(dirname(__DIR__).'/vendor/autoload.php');

use \MiniFreezer\MiniFreezer;
use \MiniFreezer\CouchDB;

$base = new EventBase();
$mf = new CouchDB([
	'database'=>'test',
	'base'=>$base,
	'port'=>5984,
	'host'=>'datashovel_couchdb',
	'dns_base'=>new EventDnsBase($base,true)
]);

class Stuff extends MiniFreezer { }

$start = microtime(true);
$obj = $mf->fetch('12345');
$obj->a = 42;
$mf->store($obj);
echo microtime(true) - $start;
echo PHP_EOL;