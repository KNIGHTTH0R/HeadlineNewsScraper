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
class CNNIndonesia extends BaseHandler implements HandlerContract
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
		$this->url = "https://www.cnnindonesia.com/";
	}

	public function exec()
	{
		/*$this->result = parent::__curl_exec(
			$this->url, 
			[
				CURLOPT_COOKIEFILE => data."/cookies/liputan6.ck",
				CURLOPT_COOKIEJAR => data."/cookies/liputan6.ck",
			]
		)['content'];*/
		
		// file_put_contents("a.tmp", $this->result);
		$this->result = file_get_contents("cnn.tmp");
	}

	public function parse()
	{
		$a = $this->result;
		$b = explode("<section id=\"headline\">\"", $a, 2);
		if (isset($b[1])) {
			var_dump($b[1]);die;
		}
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