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

$stuff = new Stuff();
$stuff->_id = "12345";
$stuff->a = 1;
$stuff->b = 2;

$mf->store($stuff);
