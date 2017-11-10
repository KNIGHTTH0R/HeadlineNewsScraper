<?php 
$pdo = new PDO("mysql:host=localhost;dbname=test_aa", "root", "858869123");
$st = $pdo->prepare("SELECT `title` FROM `news`;");
$st->execute();

$container = [];
$exclude = explode("\n",file_get_contents("stopwordbahasa.csv"));
array_walk($exclude, function(&$a){
	$a = trim($a);
});
while ($_st = $st->fetch(PDO::FETCH_NUM)) {
	foreach (explode(" ", $_st[0]) as $val) {
		$val = strtolower($val);
		$val = trim(preg_replace("#[^a-z0-9]#", "", $val));
		if(!empty($val) && ! in_array($val, $exclude)){
		isset($container[$val]) and $container[$val]++ or $container[$val] = 1;
		}
	}
}
$cont = $container;
rsort($container);
$i = 1;
foreach ($container as $key => $value) {
	echo ($i++).". ".($ky=array_search($value, $cont))." -> ".$value." kali" . PHP_EOL;
	unset($cont[$ky]);
	if ($i === 11) {
		break;
	}
}
