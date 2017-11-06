<?php

require __DIR__ . "/vendor/autoload.php";

$app = new IceTea\HeadlineNewsScraper(
	// new IceTea\SitesHandler\Detik,
	new IceTea\SitesHandler\Liputan6
	// new IceTea\SitesHandler\Tribunnews, 
	// new IceTea\SitesHandler\CNNIndonesia
);

$app->setInsertAction(function ($instanceName, $results) {
	/**
	 * Example :
	 *
	 * $instanceName 	"IceTea\SitesHandler\Liputan6"
	 * $results 		"Anies Akan Cabut Larangan Motor Lewat Jalan MH Thamrin"
	 */
	if (is_array($results)) {
		echo $instanceName . " : " . PHP_EOL; $i = 1;
		array_walk($results, function ($result) use(&$i) {
			echo ($i++).". ".$result . PHP_EOL;
		});
	} else {
		echo $instanceName . " : " . PHP_EOL;
		echo "1. ".$results . PHP_EOL;
	}
	echo PHP_EOL;
});

$app->run();