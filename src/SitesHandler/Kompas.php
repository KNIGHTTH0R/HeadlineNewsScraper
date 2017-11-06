<?php

namespace IceTea\SitesHandler;

use IceTea\BaseHandler;
use IceTea\Contracts\SitesHandler\Handler as HandlerContract;

/**
 *
 *
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
class Kompas extends BaseHandler implements HandlerContract
{
	/**
	 * Kompas URL.
	 *
	 * @var string
	 */
	private $url;

	/**
	 *
	 *
	 * @var string
	 */
	private $result;

	/**
	 *
	 *
	 * @var bool
	 */
	private $success = false;

	/**
	 * Constructor.
	 *
	 *
	 */
	public function __construct()
	{
		$this->url = "https://www.kompas.com";
	}

	public function exec()
	{
		//$this->result = self::__curl_exec($this->url);
		$this->result = file_get_contents("kompas.tmp");
	}

	public function parse()
	{
		$a = $this->result;
		$b = explode("<a class=\"article__link\"", $this->result);
		unset($b[0]);
		$this->result = [];
		foreach ($b as $val) {
			$val = explode(">", $val, 2);
			$val = explode("<", $val[1], 2);
			$val = trim(strip_tags(html_entity_decode($val[0], ENT_QUOTES, 'UTF-8')));
			empty($val) or $this->result[] = $val;
		}
		$this->success = (bool) (sizeof($this->result) - 5);
	}

	public function isSuccess()
	{
		return $this->success;
	}

	public function getResult()
	{
		return $this->result;
	}
}