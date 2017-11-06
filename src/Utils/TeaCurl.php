<?php

namespace IceTea\Utils;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 * @version 0.0.1
 *
 */
final class TeaCurl
{
	/**
	 * URL.
	 *
	 * @var string
	 */
	private $url;

	/**
	 * Error code.
	 *
	 * @var int
	 */
	private $errno = 0;

	/**
	 * Error info.
	 *
	 * @var string
	 */
	private $error;

	/**
	 * Curl resource.
	 *
	 * @var resource
	 */
	private $ch;

	/**
	 * Curl options.
	 *
	 * @var array
	 */
	private $opt = [];

	/**
	 * Curl info.
	 *
	 * @var array
	 */
	private $info = [];

	/**
	 * Is executed?
	 *
	 * @var bool
	 */
	private $isExecuted = false;

	/**
	 * Curl result.
	 *
	 * @var string
	 */
	private $output;

	/**
	 * Constructor.
	 *
	 * @param string $url
	 */
	public function __construct($url)
	{
		$this->url = $url;
	}

	private function init()
	{
		$this->ch = curl_init($this->url);
		$this->opt = [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_FOLLOWLOCATION => false
		];
	}

	/**
	 * Get info
	 *
	 * @param string|null $key
	 * @return mixed
	 */
	public function getInfo($key = null)
	{
		return 
			is_null($key) 
				? $this->info 
					: (
						isset($this->info[$key]) 
							? $this->info[$key] 
								: null);
	}

	/**
	 * Set option.
	 *
	 * @param array|null $opt
	 */
	public function setOpt($opt = null)
	{
		if (is_array($opt)) {
			foreach ($opt as $key => $val) {
				$this->opt[$key] = $val;
			}
			return true;
		}
	}

	/**
	 * Exec curl.
	 *
	 * @return string
	 */
	public function exec()
	{
		$this->__exec();
		return $this->output;
	}

	private function __exec()
	{
		$this->output = curl_exec($this->ch);
		$this->info = curl_getinfo($this->ch);
		$this->errno = curl_errno($this->ch);
		$this->error = curl_errno($this->ch);
	}

	public function errorInfo()
	{
		return $this->error;
	}

	public function errno()
	{
		return $this->errno;
	}
}