<?php

require __DIR__ . "/vendor/autoload.php";

$app = new IceTea\HeadlineNewsScraper(
	new IceTea\SitesHandler\Kompas()
);
$app->run();