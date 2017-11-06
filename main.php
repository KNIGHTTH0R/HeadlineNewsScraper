<?php

require __DIR__ . "/vendor/autoload.php";

$app = new IceTea\HeadlineNewsScraper(
	new IceTea\SitesHandler\Detik(),
	new IceTea\SitesHandler\Liputan6()
);

$app->setInsertAction(function ($instanceName, $headlineNewsTitle) {
	/**
	 * Example :
	 *
	 * $instanceName 	  "IceTea\SitesHandler\Liputan6"
	 * $headlineNewsTitle "Anies Akan Cabut Larangan Motor Lewat Jalan MH Thamrin"
	 */
	echo $instanceName . " -> ".$headlineNewsTitle . PHP_EOL;
});

$app->run();