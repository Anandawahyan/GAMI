<?php

if (!function_exists('convertToRupiah')) {
    function convertToRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 2, ',', '.');
    }
}

if (!function_exists('convertDateToIndo')) {
    function convertDateToIndo($date)
    {
        \Moment\Moment::setLocale('id_ID');
        $m = new \Moment\Moment($date);
        $formattedDate = $m->format('D, d-M-y');
        return $formattedDate;
    }
}
