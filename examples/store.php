<?php

require(__DIR__.'/common.php');

$stuff = new Stuff();
$stuff->_id = "12345";
$stuff->a = 1;
$stuff->b = 2;

$stuff2 = new Stuff();
$stuff2->_id = "12345";
$stuff2->a = 1;
$stuff2->b = 2;

var_dump($mf->store($stuff2));

$mf->store($stuff, function() use($base,$mf){
	var_dump($mf->getBuffers());
	$base->stop();
});

$base->dispatch();
