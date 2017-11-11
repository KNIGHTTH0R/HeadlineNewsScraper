<?php

namespace IceTea;

use PDO;

final class WordCloud
{
	private $pdo;

	private $pdoSt;

	private $n;

	public function __construct()
	{
		// $this->pdo = new PDO("mysql:host=localhost;dbname=test_aa", "root", "858869123");
		// $this->build();
		$this->dummy = json_decode(file_get_contents("dummy"), true);
		$this->pointer = -1;
	}

	private function build()
	{
		$this->pdoSt = $this->pdo->prepare("SELECT `title` FROM `news`;");
	}

	public function __invoke($arg)
	{
		$this->n = $arg;
		// $this->pdoSt->execute();
		$this->wd();
	}

	private function wd()
	{
		// $st = $this->pdoSt->fetch(PDO::FETCH_NUM)
		$r = [];
		while ($st = $this->dummyFetcher()) {
			$r[] = $this->b($st[0]);
		}
	}

	private function b($a)
	{
		$a = explode(" ", $a); $fl = 1;
		$j = 0; $r = [];
		while ($fl) {
			if ($j === 0) {
				$r[$j] = "";
				for ($i=0; $i < $this->n; $i++) { 
					$r[$j] .= isset($a[$i]) ? $a[$i]." " : "";
				}
				$r[$j] = $this->fixer($r[$j]);
			}		
			$fl = 0;
		}
	}

	private function fixer($str)
	{
		return trim(preg_replace("#[^a-z0-9\s]#", "", strtolower($str)));
	}

	private function dummyFetcher()
	{
		$this->pointer++;
		return isset($this->dummy[$this->pointer]) ? $this->dummy[$this->pointer] : false;
	}
}