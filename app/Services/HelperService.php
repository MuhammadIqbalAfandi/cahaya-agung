<?php

namespace App\Services;

class HelperService
{
    public static function addPrevValue(array $array)
    {
        $i = [];

        for ($j = 0; $j <= count($array) - 1; $j++) {
            if ($j === 0) {
                array_push($i, $array[$j]);
            } else {
                array_push($i, $i[$j - 1] + $array[$j]);
            }
        }

        return $i;
    }

    public static function rupiahFormat(int $num, bool $sign = true)
    {
        if ($sign) {
            if ($num < 0) {
                return "-Rp" . number_format(abs($num), 0, ",", ".");
            } else {
                return "Rp" . number_format($num, 0, ",", ".");
            }
        } else {
            if ($num < 0) {
                return "-" . number_format(abs($num), 0, ",", ".");
            } else {
                return number_format($num, 0, ",", ".");
            }
        }
    }

    public static function ppn(int $price, int $ppn)
    {
        return $price + $price * ($ppn / 100);
    }
}
