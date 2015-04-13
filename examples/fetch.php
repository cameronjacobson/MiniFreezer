<?php

require_once(__DIR__.'/common.php');

$start = microtime(true);
var_dump($mf->fetch('12345'));
echo microtime(true) - $start;
echo PHP_EOL;
