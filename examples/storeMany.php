<?php

require(__DIR__.'/common.php');

$stuff = new Stuff();
$stuff->_id = "12345";
$stuff->a = 1;
$stuff->b = 2;

$stuff2 = new Stuff();
$stuff2->_id = "54321";
$stuff2->a = 3;
$stuff2->b = 4;

$mf->storeMany([$stuff,$stuff2], function() use($base,$mf) {
	var_dump($mf);
	var_dump($mf->getBuffers());
	$base->stop();
});

$base->dispatch();
