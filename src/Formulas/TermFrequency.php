<?php

namespace IceTea\Formulas;

class TermFrequency
{
    public function __invoke($n, $sigma)
    {
        return $n / $sigma;
    }
}
