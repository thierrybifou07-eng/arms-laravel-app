<?php

namespace App\Helpers;

use NumberFormatter;

/**
 * Currency Helper - Utilities for currency formatting and calculations
 */
class CurrencyHelper
{
    protected static string $currency = 'DZD'; // Default Algerian Dinar

    /**
     * Format currency
     */
    public static function format($amount, string $currency = null): string
    {
        $currency = $currency ?? self::$currency;
        $formatter = new NumberFormatter('fr_DZ', NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, $currency);
    }

    /**
     * Parse currency string to float
     */
    public static function parse(string $value): float
    {
        // Remove currency symbols and whitespace
        $value = preg_replace('/[^0-9,.-]/', '', $value);
        $value = str_replace(',', '.', $value);
        return (float) $value;
    }

    /**
     * Calculate percentage
     */
    public static function calculatePercentage(float $amount, float $percentage): float
    {
        return ($amount * $percentage) / 100;
    }

    /**
     * Apply tax
     */
    public static function applyTax(float $amount, float $taxRate = 19): float
    {
        return $amount + self::calculatePercentage($amount, $taxRate);
    }

    /**
     * Calculate discount
     */
    public static function applyDiscount(float $amount, float $discountPercent): float
    {
        return $amount - self::calculatePercentage($amount, $discountPercent);
    }

    /**
     * Round currency
     */
    public static function round(float $amount, int $decimals = 2): float
    {
        return round($amount, $decimals);
    }

    /**
     * Compare currencies
     */
    public static function isEqual(float $amount1, float $amount2, int $decimals = 2): bool
    {
        return self::round($amount1, $decimals) === self::round($amount2, $decimals);
    }

    /**
     * Get currency symbol
     */
    public static function getSymbol(string $currency = null): string
    {
        $currency = $currency ?? self::$currency;
        $formatter = new NumberFormatter('fr_DZ', NumberFormatter::CURRENCY);
        return $formatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
    }

    /**
     * Convert to smallest unit (cents, fils, etc.)
     */
    public static function toSmallestUnit(float $amount): int
    {
        return (int) ($amount * 100);
    }

    /**
     * Convert from smallest unit
     */
    public static function fromSmallestUnit(int $amount): float
    {
        return $amount / 100;
    }
}
