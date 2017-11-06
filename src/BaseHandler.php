<?php

namespace IceTea;

use IceTea\Utils\TeaCurl;

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
	protected static function __curl_exec($url, $opt = null)
	{
		$ch = new TeaCurl($url);
		if (is_array($opt)) {
			$ch->set_opt($opt);
		}
		$out = $ch->exec();
		$err = $ch->errorInfo() and $out = "Error (".($ch->errno()).") : ".$err;
		$ch->close();
		return $out;
	}
}