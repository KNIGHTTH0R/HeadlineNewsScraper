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
		if (! defined("data")) {
			throw new \Exception("data constant not defined!", 1);
		}
		is_dir(data) or mkdir(data);
		is_dir(data."/cookies") or mkdir(data."/cookies");
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

	public function setInsertAction(\Closure $func)
	{
		$this->insertAction = $func;
	}

	private function save(BaseHandler $instance)
	{
		$instance->parse();
		if ($instance->isSuccess()) {
			$func = $this->insertAction;
			$func(get_class($instance), $instance->getResult());
		} else {
			print get_class($instance)." failed!" . PHP_EOL;
		}
	}
}