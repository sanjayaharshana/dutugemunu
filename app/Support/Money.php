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
}
