<?php

namespace App\Support;

class Money
{
    /**
     * Format a rupee amount for display, e.g. "Rs. 1,850,000" or "Rs. 1,850,000.50".
     * Whole numbers are shown with no decimals; fractional amounts keep 2.
     */
    public static function format(float|int|string|null $amount): string
    {
        $amount = (float) $amount;
        $decimals = fmod($amount, 1.0) === 0.0 ? 0 : 2;

        return 'Rs. ' . number_format($amount, $decimals);
    }

    /**
     * Compact form for tight spaces (e.g. a dashboard stat tile), like "Rs. 4.85M"
     * or "Rs. 12.5k". Falls back to format() below 1,000.
     */
    public static function abbreviate(float|int|string|null $amount): string
    {
        $amount = (float) $amount;
        $abs = abs($amount);

        if ($abs >= 1_000_000) {
            return 'Rs. ' . rtrim(rtrim(number_format($amount / 1_000_000, 2), '0'), '.') . 'M';
        }

        if ($abs >= 1_000) {
            return 'Rs. ' . rtrim(rtrim(number_format($amount / 1_000, 1), '0'), '.') . 'k';
        }

        return self::format($amount);
    }
}
