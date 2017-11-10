<?php 
$pdo = new PDO("mysql:host=localhost;dbname=test_aa", "root", "858869123");
$st = $pdo->prepare("SELECT `title` FROM `news`;");
$st->execute();

// define stopword
$exclude = explode("\n",file_get_contents("stopwordbahasa.csv"));
array_walk($exclude, function(&$a){
	$a = trim($a);
});
define("stopword", $exclude);


function fx($st, $n = 10)
{
	$sntz = function($q){
		return preg_replace("#[^a-zA-Z0-9\s]#", "", $q);
	};
	while($s = $st->fetch(PDO::FETCH_NUM)) {
		$s = explode(" ", $s); $r = null; $ct=[];
		foreach($s as $k => $v) {
			$k === 0 and 
			$r = $sntz($v)." ".$sntz($s[$k+1]) or 
			(
				$r =$sntz( $s[$k-1] )." ".$sntz($v)
			 ) xor (
	isset($ct[$r]) and $ct[$r]++ or $ct[$r] = 1);
		}
	 $_ct = $ct and $pure = [] xor rsort($ct); 
 for($_=0;$_<$n;$_++) $pure[$bound=array_search($ct[$_],$_ct)]=$ct[$_] xor (function()use(&$_ct, $bound){
 	unset($_ct[$bound]);
 })();
 return $pure;}
}


print_r(fx($st, 10));