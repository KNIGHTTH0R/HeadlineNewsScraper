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
                        $d = trim(strip_tags(html_entity_decode($d[0], ENT_QUOTES, 'UTF-8')));
                        empty($d) or $this->result[] = $d;
                    }
                    $b = explode('<div class="pos_abs ovh hlover" >', $a);
                    foreach ($b as $val) {
                        $val = explode("title=\"", $val, 2);
                        $val = explode("\"", $val[1], 2);
                        $val = trim(strip_tags(html_entity_decode($val[0], ENT_QUOTES, 'UTF-8')));
                        empty($val) or $this->result[] = $val;
                    }
                    $b = explode("<div class=\"grey2 pt5 f13 ln18 txt-oev-2\">", $a);
                    foreach ($b as $val) {
                        $val = explode("<", $val, 2);
                        $val = trim(strip_tags(html_entity_decode($val[0], ENT_QUOTES, 'UTF-8')));
                        empty($val) or $this->result[] = $val;
                    }
                    $this->result = array_unique($this->result);
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
