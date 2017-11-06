<?php

namespace IceTea;

/**
 *
 *
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 */
final class HeadlineNewsScraper
{
	/**
	 * @var array
	 */
	private $container = [];

	/**
	 * Constructor.
	 *
	 *
	 */
	public function __construct(...$handlerInstances)
	{
		foreach ($handlerInstances as $instance) {
			if ($instance instanceof BaseHandler) {
				$this->container[] = $instance;
			} else {
				throw new \Exception(
						sprintf("Handler must be instanceof %s", BaseHandler::class)
					, 1);
			}
		}
		if (! sizeof($this->container)) {
			throw new \Exception("Empty container", 1);
		}
	}

	public function run()
	{
		foreach ($this->container as $instance) {
			$instance->exec();
			$this->save($instance);
		}
	}

	private function save(BaseHandler $instance)
	{
		if ($instance->isSuccess()) {
			$a = $instance->getResult();
			var_dump($a);
		} else {
			print get_class($instance)." failed!" . PHP_EOL;
		}
	}
}