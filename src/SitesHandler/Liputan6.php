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
        $this->result = parent::__curl_exec(
            $this->url,
            [
                CURLOPT_COOKIEFILE => data."/cookies/liputan6.ck",
                CURLOPT_COOKIEJAR => data."/cookies/liputan6.ck",
            ]
        )['content'];
    }

    public function parse()
    {
        $a = $this->result;
        $this->result = [];
        $b = explode("<h2 class=\"headline--main__title\">", $a, 2);
        if (isset($b[1])) {
            $b = explode("</h2>", $b[1], 2);
            $this->result[] = trim(strip_tags(html_entity_decode($b[0], ENT_QUOTES, 'UTF-8')));
            $this->success = true;
        }
        $b = explode("<div id='parallax-unit' style='display:none'>", $a, 2);
        if (isset($b[1])) {
            $b = explode("<div id='mrec2' class=\"loading-ads\">", $b[1], 2);
            $b = explode("title=\"", $b[0]);
            unset($b[0]);
            if (count($b) > 3) {
                foreach ($b as $val) {
                    $c = explode("\"", $val, 2);
                    $r[] = $c[0];
                }
                foreach (array_unique($r) as $val) {
                    $val = trim(strip_tags(html_entity_decode($val, ENT_QUOTES, 'UTF-8')));
                    empty($val) or $this->result[] = $val;
                }
                $this->result = array_unique($this->result);
                $this->success = (bool) count($this->result);
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
