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
        $this->result = parent::__curl_exec(
			$this->url, 
			[
				CURLOPT_COOKIEFILE => data."/cookies/detik.ck",
				CURLOPT_COOKIEJAR => data."/cookies/detik.ck",
			]
		)['content'];
    }

    public function parse()
    {
        $a = $this->result;
        $this->result = [];
        $b = explode(" data-action=\"HL\" data-label=\"List Berita\">", $a, 2);
        if (isset($b[1])) {
            $b = explode("</h1>", $b[1], 2);
            $b = trim(strip_tags(html_entity_decode($b[0], ENT_QUOTES, 'UTF-8')));
            empty($b) or $this->result[] = $b;
        }

        $b = explode(" <div class=\"title_lnf\">", $a);
        unset($b[0]);
        foreach ($b as $val) {
            $c = explode("</div>", $val, 2);
            $c = trim(strip_tags(html_entity_decode($c[0], ENT_QUOTES, 'UTF-8')));
            empty($c) or $this->result[] = $c;
        }
        $this->result = array_unique($this->result);
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
