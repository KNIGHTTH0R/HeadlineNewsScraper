<?php

namespace IceTea;

use IceTea\Utils\TeaCurl;

/**
 *
 *
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
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
    final protected static function __curl_exec($url, $opt)
    {
        $ch = curl_init($url);
        $defOpt = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_VERBOSE => true
        ];
        if (is_array($opt)) {
            foreach ($opt as $key => $value) {
                $defOpt[$key] = $value;
            }
        }
        var_dump($opt);
        curl_setopt_array($ch, $defOpt);
        $out = curl_exec($ch);
        $info = curl_getinfo($ch);
        $errno = curl_errno($ch) and $out = "Error ({$errno}) : ".curl_error($ch);
        return [
            "content" => $out,
            "info" => $info
        ];
    }
}
