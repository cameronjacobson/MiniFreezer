<?php

require(__DIR__.'/common.php');

$start = microtime(true);
$obj = $mf->fetch('12345');
$obj->a = 42;
$mf->store($obj);
echo microtime(true) - $start;
echo PHP_EOL;
