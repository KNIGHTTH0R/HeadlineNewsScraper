<?php

namespace IceTea;

use IceTea\Utils\TeaCurl;

/**
 *
 *
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
abstract class BaseHandler
{
	abstract public function __construct();

	public function exec()
	{
		throw new \Exception("Must override!", 1);
	}

	public function getResult()
	{
		throw new \Exception("Must override!", 1);	
	}

	/**
	 * Curl execution
	 *
	 * @param string $url
	 * @param string $opt
	 * @return string
	 */
	final protected static function __curl_exec($url, $opt = null)
	{
		$ch = new TeaCurl($url);
		$defaultOpt = [
			CURLOPT_TIMEOUT 		=> 40,
			CURLOPT_CONNECTTIMEOUT	=> 15,
			CURLOPT_FOLLOWLOCATION	=> true
		];
		if (is_array($opt)) {
			foreach ($opt as $key => $value) {
				$defaultOpt[$key] = $value;
			}
		}
		$ch->setOpt($defaultOpt);
		$out = $ch->exec();
		$err = $ch->errorInfo() and $out = "Error (".($ch->errno()).") : ".$err;
		$ch->close();
		return $out;
	}
}