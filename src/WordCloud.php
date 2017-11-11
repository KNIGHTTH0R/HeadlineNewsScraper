<?php

namespace IceTea;

use PDO;

final class WordCloud
{
	private $pdo;

	private $pdoSt;

	public function __construct()
	{
		$this->pdo = new PDO("mysql:host=localhost;dbname=test_aa", "root", "858869123");
		$this->build();
	}

	private function build()
	{
		$this->pdoSt = $this->pdo->prepare("SELECT `title` FROM `news`;");
	}

	public function __invoke()
	{
		$this->pdoSt->execute();
		$this->wd();
	}

	private function wd()
	{
		while ($st = $this->pdoSt->fetch(PDO::FETCH_NUM)) {
			$data[] = $st;
		}
		file_put_contents("dummy", json_encode($data));
	}
}