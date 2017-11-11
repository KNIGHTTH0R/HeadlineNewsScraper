<?php

require __DIR__."/vendor/autoload.php";

try {
	$app = new \IceTea\WordCloud();
	print "Input n : ";
	$input = fgets(STDIN, 1024);
	print PHP_EOL . PHP_EOL;
	$app($input);	
} catch (Exception $e) {
	echo get_class($e). " : ". $e->getMessage() . PHP_EOL;
}
