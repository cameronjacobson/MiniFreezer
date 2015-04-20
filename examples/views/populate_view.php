<?php

/**
 *  Example assumes you will set up your own mock view to query.
 */

require_once(dirname(dirname(__DIR__)).'/vendor/autoload.php');

require(dirname(__DIR__).'/common.php');

$obj = new ViewTestClass();
$obj->name = 'john';
$obj->microtime = microtime(true);

$obj2 = new ViewTestClass();
$obj2->name = 'jane';
$obj2->microtime = microtime(true);

$result = $mf->store($obj);
var_dump($result);
$mf->store($obj2, function() use($base,$mf) {
	var_dump($mf->getBuffers());
	echo 'done'.PHP_EOL;
	$base->exit();
});

$base->dispatch();

