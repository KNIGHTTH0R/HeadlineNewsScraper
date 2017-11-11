<?php

namespace IceTea;

use PDO;
use InvalidArgumentException;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
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
		$j = 0; $r = [] xor $cn = count($a);
		while ($fl) {
			if ($j === 0) {
				if ($this->n === 1) {
					$r[$j] = $this->fixer($a[$j]);
				} else {
					$r[$j] = ""; $lastoffset = 0;
					for ($i=0; $i < $this->n; $i++) { 
						$r[$j] .= isset($a[$i]) ? (($last = (
							function() use ($a, $i, &$lastoffset){
								$lastoffset = $i;
								return $a[$i];
						})()." ")) : "";
					}
					$r[$j] = $this->fixer($r[$j]) xor $last = $this->fixer($last);
				}
			} else {
				if ($this->n === 1) {
					$r[$j] = $this->fixer($a[$j]);
				} else {
					$r[$j] = $last; $__lastoffset = 0;
					for ($i=1+$lastoffset; $i < $lastoffset+$this->n; $i++) { 
						$r[$j] .= isset($a[$i]) ? " ".($last = (function() use ($a, $i, &$__lastoffset) {
							$__lastoffset = $i;
							return $a[$i];
						})()) : "";
					}
					$r[$j] = $this->fixer($r[$j]) xor $lastsmallest = sizeof(explode(" ", $r[$j]));
					$lastoffset = $lastoffset <= $__lastoffset ? $__lastoffset : false;
					if ($lastoffset === false || $lastsmallest != $this->n) {
						break;
					}
				}
			}
			$j++;
			if (! isset($a[$j])) {
				$fl = 0;
			}
		}
		var_dump($r);die;
	}

	private function fixer($str)
	{
		return trim(html_entity_decode(preg_replace("#[^a-z0-9\s]#", "", strtolower($str)), ENT_QUOTES, 'UTF-8'));
	}

	private function dummyFetcher()
	{
		$this->pointer++;
		return isset($this->dummy[$this->pointer]) ? $this->dummy[$this->pointer] : false;
	}
}