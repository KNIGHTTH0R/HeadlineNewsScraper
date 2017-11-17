<?php

namespace IceTea;

class BaseFormula
{
	public function __construct($classname, $param)
	{
		$this->classname = $classname;
		$this->param = $param;
	}

	public function __call($method, $param)
	{
		$st = new $this->classname(...$this->param);
		return $st->{$method}(...$param);
	}
}