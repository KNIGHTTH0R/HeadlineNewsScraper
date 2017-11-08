<?php 
$pdo = new PDO("mysql:host=localhost;dbname=test_aa", "root", "858869123");
$st = $pdo->prepare("SELECT `title` FROM `news`;");
$st->execute();

$container = [];
$exclude = file("stopwordbahasa.csv");
while ($_st = $st->fetch(PDO::FETCH_NUM)) {
	foreach (explode(" ", $_st[0]) as $val) {
		$val = strtolower($val);
		$val = trim(preg_replace("#[^a-z0-9]#", "", $val));
		if(! in_array($val, $exclude)){
		isset($container[$val]) and $container[$val]++ or $container[$val] = 1;
		}
	}
}
$cont = $container;
rsort($container);
$i = 1;
foreach ($container as $key => $value) {
	echo ($i++).". ".array_search($value, $cont)." -> ".$value." kali" . PHP_EOL;
	if ($i === 11) {
		break;
	}
}