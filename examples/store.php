<?php

require(__DIR__.'/common.php');

$stuff = new Stuff();
$stuff->_id = "12345";
$stuff->a = 1;
$stuff->b = 2;

$mf->store($stuff);
