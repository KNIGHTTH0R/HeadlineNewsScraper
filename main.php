<?php

require __DIR__ . "/vendor/autoload.php";

while (true) {
    $pdo = new PDO("mysql:host=localhost;dbname=test_aa", "root", "858869123");
    $st = $pdo->prepare("INSERT INTO `news` (`hash`,`site`,`title`,`created_at`) VALUES (:hash, :site, :title, :created_at);");


    $app = new IceTea\HeadlineNewsScraper(
        new IceTea\SitesHandler\Kompas,
        new IceTea\SitesHandler\Detik,
    	new IceTea\SitesHandler\Liputan6,
    	new IceTea\SitesHandler\Tribunnews,
    	new IceTea\SitesHandler\CNNIndonesia
    );
    $app->setInsertAction(function ($instanceName, $results) use ($st) {
        /**
         * Example :
         *
         * $instanceName    "IceTea\SitesHandler\Liputan6"
         * $results         "Anies Akan Cabut Larangan Motor Lewat Jalan MH Thamrin"
         */
        $instanceName = explode("\\", $instanceName);
        $instanceName = end($instanceName);
        foreach ($results as $key => $value) {
            $st->execute(
            [
                ":hash" => sha1($value),
                ":site" => $instanceName,
                ":title" => $value,
                ":created_at" => time()
            ]);
        ) 
        }

        echo $instanceName . " : " . PHP_EOL;
        $i = 1;
        array_walk($results, function ($result) use (&$i) {
            echo ($i++).". ".$result . PHP_EOL;
        });
        
        echo PHP_EOL;
    });

    $app->run();

    // delay
    sleep(60);
}