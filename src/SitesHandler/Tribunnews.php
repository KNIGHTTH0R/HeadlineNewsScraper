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
class Tribunnews extends BaseHandler implements HandlerContract
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
		$this->url = "http://www.tribunnews.com/";
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
		$this->result = file_get_contents("tribun.tmp");
	}

	public function parse()
	{
		$a = $this->result;
		$b = explode("<div id=\"topil\" class=\"\">", $a, 2);
		$this->result = [];
		if (isset($b[1])) {
			$b = explode("<script type=\"text/javascript\">", $b[1], 2);
			if (isset($b[1])) {
				$c = explode("<div id=\"topik_", $b[0]);
				unset($c[0]);
				if (isset($c[1], $c[2])) {
					foreach ($c as $val) {
						$d = explode("<a href=\"", $val, 2);
						$d = explode(">", $d[1], 2);
						$d = explode("<", $d[1], 2);
						$this->result[] = trim(strip_tags(html_entity_decode($d[0], ENT_QUOTES, 'UTF-8')));
					}
					$b = explode('<div class="pos_abs ovh hlover" >', $a);
					foreach ($b as $val) {
						$c = explode("title=\"", $val, 2);
						$c = explode("\"", $c[1], 2);
						 $this->result[] = trim(strip_tags(html_entity_decode($c[0], ENT_QUOTES, 'UTF-8')));
					}
					$this->success = (bool) (sizeof($this->result) - 1);
				}
			}
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