<?php

require __DIR__."/vendor/autoload.php";

$app = new \IceTea\WordCloud();
print "Input n : ";
$input = fgets(STDIN, 1024);
print PHP_EOL . PHP_EOL;
$app((int) $input);
