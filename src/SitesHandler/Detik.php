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
class Detik extends BaseHandler implements HandlerContract
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
		$this->url = "http://www.detik.com/";
	}

	public function exec()
	{
		/*$this->result = parent::__curl_exec(
			$this->url, 
			[
				CURLOPT_COOKIEFILE => data."/cookies/detik.ck",
				CURLOPT_COOKIEJAR => data."/cookies/detik.ck",
			]
		)['content'];
		
		file_put_contents("detik.tmp", $this->result);*/
		$this->result = file_get_contents("detik.tmp");
	}

	public function parse()
	{
		$a = $this->result;
		$b = explode(" data-action=\"HL\" data-label=\"List Berita\">", $a, 2);
		if (isset($b[1])) {
			$b = explode("</h1>", $b[1], 2);
			$this->result = trim(strip_tags(html_entity_decode($b[0], ENT_QUOTES, 'UTF-8')));
			$this->success = true;
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