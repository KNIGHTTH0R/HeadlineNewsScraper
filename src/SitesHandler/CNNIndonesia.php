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
        $this->result = [];
        $b = explode("<h2 class=\"title\">", $a);
        unset($b[0]);
        foreach ($b as $val) {
            $val = explode("<", $val, 2);
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
