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
class Liputan6 extends BaseHandler implements HandlerContract
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
		$this->url = "http://www.liputan6.com/";
	}

	public function exec()
	{
		$this->result = self::__curl_exec($this->url);
	}

	public function parse()
	{

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