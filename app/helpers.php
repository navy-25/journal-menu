<?php

use App\Helpers\UserAccessHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

date_default_timezone_set('Asia/Jakarta');

// SIDEBAR
if (!function_exists('activeMenu')) {
    function activeMenu($route)
    {
        return strpos(Route::current()->getName(), $route) !== false ? 'active' : '';
    }
}
// END SIDEBAR

// FORM
if (!function_exists('activeSelect')) {
    function activeSelect($data_select, $data_real)
    {
        return $data_select ==  $data_real ? 'selected' : '';
    }
}
// END FORM

// ABJAD & NUMERIK
if (!function_exists('str_to_int')) {
    function str_to_int($number)
    {
        return (int)str_replace('.', '', ($number));
    }
}
if (!function_exists('unNegativeNumber')) {
    function unNegativeNumber($number)
    {
        return $number * -1;
    }
}
if (!function_exists('numberFormat')) {
    function numberFormat($number, $number_coma = 0, $sparator1 = '.', $sparator2 = ',')
    {
        return number_format($number, $number_coma, $sparator2, $sparator1);
    }
}
if (!function_exists('sentenceCase')) {
    function sentenceCase($text)
    {
        return ucwords($text);
    }
}

if (!function_exists('lowercase')) {
    function lowerCase($text)
    {
        return strtolower($text);
    }
}

if (!function_exists('uppercase')) {
    function upperCase($text)
    {
        return strtoupper($text);
    }
}

if (!function_exists('firstCase')) {
    function firstCase($text)
    {
        return ucfirst($text);
    }
}
// END ABJAD & NUMERIK

// CUSTOM DATE
if (!function_exists('customDate')) {
    function customDate($date, $format)
    {
        return date($format, strtotime($date));
    }
}

if (!function_exists('operatorDate')) {
    function operatorDate($date, $operator)
    {
        $data = date('Y-m-d', strtotime($operator, strtotime($date)));
        return $data;
    }
}

if (!function_exists('dateFormat')) {
    function dateFormat($date)
    {
        $day = date('d', strtotime($date));
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $date =  $day . ' ' . $months[(int)$month - 1] . ' ' . $year;
        return $date;
    }
}

if (!function_exists('dateTimeFormat')) {
    function dateTimeFormat($date)
    {
        $day = date('d', strtotime($date));
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $date =  $day . ' ' . $months[(int)$month - 1] . ' ' . $year . ' ' . date('H:i', strtotime($date));
        return $date;
    }
}

if (!function_exists('dateFormatDay')) {
    function dateFormatDay($date)
    {
        $day_name = date('D', strtotime($date));
        $day = date('d', strtotime($date));
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $day_names = ['mon' => 'Minggu', 'tue' => 'Selasa', 'wed' => 'Rabu', 'thu' => 'Kamis', 'fri' => 'Jumat', 'sat' => 'Sabtu',];
        $date =  $day_names[strtolower($day_name)] . ', ' . $day . ' ' . $months[(int)$month - 1] . ' ' . $year;
        return $date;
    }
}
// END CUSTOM DATE