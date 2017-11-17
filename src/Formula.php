<?php

namespace IceTea;

class Formula
{
    public static function __callStatic($method, $param)
    {
        $classname = "\\IceTea\\Formulas\\{$method}";
        if (class_exists($classname)) {
            return new BaseFormula($classname, $param);
        }
        throw new \Exception("Formula not found!", 1);
    }
}
