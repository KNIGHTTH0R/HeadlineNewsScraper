<?php 
$pdo = new PDO("mysql:host=localhost;dbname=test_aa", "root", "858869123");
$st = $pdo->prepare("SELECT `title` FROM `news`;");
$st->execute();

$container = [];

while ($_st = $st->fetch(PDO::FETCH_NUM)) {
	foreach (explode(" ", $_st[0]) as $val) {
		$val = strtolower($val);
		isset($container[trim($val)]) and $container[$val]++ or $container[$val] = 1;
	}
}

rsort($container);
$i = 1;
foreach ($container as $key => $value) {
	if ($i === 10) {
		break;
	}
	echo ($i++).". {$key} -> {$value} kali" . PHP_EOL;
}
