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

	private $stopword = [];

	public function __construct()
	{
		$this->pdo = new PDO("mysql:host=localhost;dbname=test_aa", "root", "858869123");
		$this->build();
		// $this->dummy = json_decode(file_get_contents("dummy"), true);
		$this->pointer = -1;
		$this->stopword = explode("\n", file_get_contents("stopwordbahasa.csv"));
		array_walk($this->stopword, function(&$a) {
			$a = trim($a);
		});
	}

	private function build()
	{
		$this->pdoSt = $this->pdo->prepare("SELECT `title` FROM `news`;");
	}

	public function __invoke($arg)
	{
		$arg = trim($arg);
		if (! is_numeric($arg)) {
			throw new InvalidArgumentException("argv is not numeric", 1);
		} elseif (($arg = (int)$arg) < 1) {
			throw new InvalidArgumentException("argv should greater than 0", 1);
		}
		$this->n = $arg;
		$this->pdoSt->execute();
		$this->wd();
	}

	private function wd()
	{
		$r = []; $i = 1;
		while ($st = $this->pdoSt->fetch(PDO::FETCH_NUM)) {
			foreach ($this->b($st[0]) as $val) {
				str_replace(" ", "", $val, $n);
				if ($n === $this->n - 1) {
					isset($r[$val]) and $r[$val]++ or $r[$val] = 1;
				}
			}
		}
		$backup = $r;
		rsort($r);
		for($i=0;$i<10;$i++){
			echo "  ".($i+1).". ".($value_to_unset = array_search($r[$i], $backup))." -> ".$r[$i] . PHP_EOL;
			unset($value_to_unset);
		}
	}

	private function b($a)
	{
		$pure = strtolower($a);
		$a = explode(" ", $a); $fl = 1; $sw = false;
		foreach ($a as $k => &$val) {
			$val = $this->fixer($val);
			if (in_array($val, $this->stopword)) {
				$sw = true; unset($a[$k]);
			}
		}
		if ($this->n === 1) {
			return $a;
		}
		if ($sw) {
			$_a = []; $i = 0;
			foreach ($a as $val) {
				$_a[$i++] = $val;
			}
			$a = $_a;
		}
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
					$q = explode(" ", $r[$j-1]);
					if ($lastsmallest === 1 && $this->n > 2 || $r[$j] === end($q)) {
						unset($r[$j]);
					}
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
		return $r;
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