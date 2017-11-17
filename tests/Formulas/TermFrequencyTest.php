<?php

namespace tests\Formulas;

use IceTea\Formula;
use PHPUnit\Framework\TestCase;

class TermFrequencyTest extends TestCase
{
	public function test1()
	{
		/*
		 Anggaplah anda memiliki sebuah tulisan dengan jumlah kata 100 dan di sana muncul kata kucing sebanyak 5 kali. Kalkulasi untuk Term Frequency adalah sebagai berikut:

		 TF = 5/100 = 0,05
		*/
		$needle_count = 5;
		$haystack_count = 100;
		$this->assertEquals(
			Formula::TermFrequency($needle_count, $haystack_count)(), 0.05
		);
	}
}