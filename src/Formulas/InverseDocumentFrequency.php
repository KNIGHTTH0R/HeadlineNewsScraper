<?php

namespace IceTea\Formulas;

class InverseDocumentFrequency
{
	public function __invoke($n, $sigma)
	{
		return log($sigma / $n, 10);
	}
}