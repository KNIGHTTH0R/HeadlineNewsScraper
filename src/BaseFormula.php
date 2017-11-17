<?php

namespace IceTea;

class BaseFormula
{
    public function __construct($classname, $param)
    {
        $this->classname = $classname;
        $this->param = $param;
        $this->st = new $this->classname(...$param);
    }

    public function __call($method, $param)
    {
        return $st->{$method}(...$param);
    }

    public function __invoke()
    {
        $st = $this->st;
        return $st(...$this->param);
    }
}
