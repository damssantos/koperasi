<?php

namespace App\Support;

class NumberHelper
{
    /**
     * Format a number into short Rupiah format (e.g., Rp 3.5M, Rp 12M).
     *
     * @param float|int $value
     * @return string
     */
    public static function formatM($value)
    {
        $absVal = abs($value);
        $sign = $value < 0 ? '-' : '';
        
        if ($absVal >= 1000000000) {
            $valInBillion = $absVal / 1000000000;
            if (floor($valInBillion) == $valInBillion) {
                return $sign . 'Rp ' . number_format($valInBillion, 0, ',', '.') . 'M';
            } else {
                return $sign . 'Rp ' . number_format($valInBillion, 1, ',', '.') . 'M';
            }
        } elseif ($absVal >= 1000000) {
            $valInMillion = $absVal / 1000000;
            if (floor($valInMillion) == $valInMillion) {
                return $sign . 'Rp ' . number_format($valInMillion, 0, ',', '.') . ' Jt';
            } else {
                return $sign . 'Rp ' . number_format($valInMillion, 1, ',', '.') . ' Jt';
            }
        } else {
            return $sign . 'Rp ' . number_format($absVal, 0, ',', '.');
        }
    }
}
