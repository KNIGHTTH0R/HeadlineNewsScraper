<?php

namespace tests\Formulas;

use IceTea\Formula;
use PHPUnit\Framework\TestCase;

	// https://suhardimunir.web.id/blog/pengertian-dan-kegunaan-tf-idf/

	// Pengertian TF-IDF

	// TF-IDF adalah kepanjangan dari Term Frequency-Inverse Document Frequency dan biasanya digunakan untuk memperoleh informasi lebih dalam tentang teks. TF-IDF ini adalah sebuah ukuran statistik yang digunakan untuk mengevaluasi seberapa penting sebuah kata di dalam sebuah dokumen atau dalam sekelompok kata. Seberapa pentingnya sebuah kata tersebut akan meningkat secara proporsional berdasarkan berapa kali kata tersebut muncul di dokumen tadi di dalam kumpulan kata tadi. Variasi skema kedalaman kata ini umumnya digunakan oleh mesin pencari sebagai alat utama untuk memberikan skor dan penilaian terhadap seberapa relevan dokumen tersebut terhadap kueri yang digunakan oleh seorang user. Dengan kata lain, TF-IDF merupakan salah satu cara untuk mengelompokkan atau mengkategorikan sebuah dokumen.

	// Algoritma ini akan berguna ketika anda telah memiliki sejumlah besar kumpulan dokumen yang akan dikategorikan. Bayangkan website perusahaan besar dengan 10 ribu kontributor yang mengirimkan tulisan ke website tersebut. Tergantung dari tag yang disisipkan di tiap postingan, item ini akan muncul pada daftar halaman dalam berbagai bagian dari situs. Walaupun si penulis bisa memberi tag secara manual ketika mereka menulis sebuah konten, tetapi biasanya mereka lupa memberi tag ini, dan akhirnya terhadap ribuan tulisan yang tidak terkelompokkan melalui tag ini. Hanya sedikit penulis yang mau menyisihkan waktu untuk menambahkan tag sewaktu menulis sebuah tulisan. Untuk dokumen seperti inilah (yang tidak dikelompokkan dengan menggunakan tag) TF-IDF berguna, karena dia bisa menghasilkan tag untuk tulisan tersebut dan membantu sekali dalam mengelompokkan area yang cocok.

	// Pentingnya sebuah kata akan meningkat secara proporsional berdasarkan seberapa sering kata tersebut muncul di dalam sebuah dokumen. Akan tetapi, jika beberapa dokumen berisikan kata yang sama muncul beberapa kali, maka ini akan menjadi sebuah masalah. Itulah makanya TF-IDF juga mengimbangi nilai kata tadi dengan frekuensi istilah di seluruh dokumen, nilainya disebut dengan Inverse Document Frequency.


	// Latihan 1
	// 	1. Anggaplah anda memiliki sebuah tulisan dengan jumlah kata 100 dan di sana muncul kata kucing sebanyak 5 kali. Kalkulasi untuk Term Frequency adalah sebagai berikut:
	// 		TF = 5/100 = 0,05

	// 	2. Selanjutnya diasumsikan anda memiliki tulisan di blog tadi sebanyak 10.000 buah dokumen dan kata kucing muncul sebanyak 100 kali. Maka kalkulasi untuk Inverse Document Frequency adalah sebagai berikut:
	// 		IDF = log (10.000/100) = 2

	// 	3. Untuk menghitung TF-IDF, kalikan kedua nilai tadi, hasilnya seperti dibawah ini:
	// 		TF-IDF = 0,05 x 2 = 0,1


class TFIDFTest extends TestCase
{

	/**
	 * @var float
	 */
	private $idf;

	/**
	 * @var float
	 */
	private $tf;

	/**
	 * @var int
	 */
	private $jumlahKata = 100;

	/**
	 * @var int
	 */
	private $kataKucing = 5;

	/**
	 * @var int
	 */
	private $totalJumlahDokumen = 10000;

	/**
	 * @var int
	 */
	private $totalKataKucing = 100;

	protected function setup()
	{
        $this->tf = Formula::TermFrequency($this->kataKucing, $this->jumlahKata)();
        $this->idf = Formula::InverseDocumentFrequency($this->totalKataKucing, $this->totalJumlahDokumen)();
	}

	public function testTF()
	{
		$this->assertEquals($this->tf, 0.05);
	}

	public function testIDF()
	{
		$this->assertEquals($this->idf, 2);
	}

	public function testTFIDF()
	{
		$this->assertEquals($this->tf * $this->idf , 0.1);
	}
}
