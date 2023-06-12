<?php
if (function_exists('convert_to_rupiah')) {
	function convert_to_rupiah($angka){
		$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
		return $hasil_rupiah;
	}
}