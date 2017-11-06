<?php 
$pdo = new PDO("mysql:host=localhost;dbname=test_aa", "root", "858869123");
$st = $pdo->prepare("SELECT `title` FROM `news`;");

$container = [];

while ($st = $st->fetch(PDO::FETCH_NUM) {
	foreach (explode(" ", $st[0]) as $val) {
		$val = strtolower($val);
		isset($container[trim($val)]) and $container[$val]++ or $container[$val] = 1;
	}
}

print array_search($container, max($container));
