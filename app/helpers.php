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
        // \Moment\Moment::setLocale('id_ID');
        $m = new \Moment\Moment($date);
        $formattedDate = $m->setTimezone('Asia/Bangkok')->format('D, d-M-y');
        return $formattedDate;
    }
}

if (!function_exists('getTime')) {
    function getTime($date)
    {
        // \Moment\Moment::setLocale('id_ID');
        $m = new \Moment\Moment($date);
        $formattedTime = $m->setTimezone('Asia/Bangkok')->format('H:i');
        return $formattedTime;
    }
}

if (!function_exists('calculateDiskon')) {
    function calculateDiskon($subtotal, $diskonPercentage)
    {
        if($diskonPercentage != null) {
            $diskonInMoney = $subtotal * ($diskonPercentage/100);
            return $diskonInMoney;
        }
        return 0;
    }
}

if (!function_exists('calculatePriceAfter')) {
    function calculatePriceAfter($subtotal, $diskon)
    {
        $diskonPrice = calculateDiskon($subtotal, $diskon);
        return $subtotal - $diskonPrice;
    }
}


