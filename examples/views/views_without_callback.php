<?php

/**
 *  Example assumes you will set up your own mock view to query.
 */

require_once(dirname(dirname(__DIR__)).'/vendor/autoload.php');

//use MiniFreezer\MiniFreezer;
use MiniFreezer\CouchDB;

$start = microtime(true);

$base = new EventBase();
$dns_base = new EventDnsBase($base,true);

$couch = new CouchDB([
	'database'  => 'test',
	'host'      => 'datashovel_couchdb',
	'base'      => $base,
	'dns_base'  => $dns_base,
	'port'      => 5984,
//	'user'      => '{{USERNAME}}',
//	'pass'      => '{{PASSWORD}}'
]);

$result = $couch->view(array(
	'database'=>'test',
	'design'=>'test',
	'view'=>'testview',
	'limit'=>10,
//	'descending'=>true,
//	'startkey'=>'06a9668f-3f5e-41d5-a2bd-3b2386b6e348',
	'include_docs'=>'true'
));

var_dump($result);
