<?php

namespace App\Helpers;

use Carbon\Carbon;

/**
 * Date Helper - Utilities for date/time operations
 */
class DateHelper
{
    /**
     * Get days until date
     */
    public static function daysUntil($date): int
    {
        return Carbon::parse($date)->diffInDays(now());
    }

    /**
     * Get days since date
     */
    public static function daysSince($date): int
    {
        return now()->diffInDays(Carbon::parse($date));
    }

    /**
     * Check if date is overdue
     */
    public static function isOverdue($date): bool
    {
        return Carbon::parse($date)->isPast();
    }

    /**
     * Check if date is in X days
     */
    public static function isDueInDays($date, int $days): bool
    {
        $daysUntil = self::daysUntil($date);
        return $daysUntil <= $days && $daysUntil >= 0;
    }

    /**
     * Get month name from date
     */
    public static function getMonthName($date): string
    {
        return Carbon::parse($date)->format('F');
    }

    /**
     * Get fiscal year
     */
    public static function getFiscalYear($date = null): string
    {
        $date = $date ? Carbon::parse($date) : now();
        $year = $date->month >= 1 ? $date->year : $date->year - 1;
        return "{$year}-" . ($year + 1);
    }

    /**
     * Add business days to date
     */
    public static function addBusinessDays($date, int $days): Carbon
    {
        $date = Carbon::parse($date);
        $added = 0;

        while ($added < $days) {
            $date->addDay();
            if (!$date->isWeekend()) {
                $added++;
            }
        }

        return $date;
    }

    /**
     * Get next month start date
     */
    public static function getNextMonthStart($date = null): Carbon
    {
        $date = $date ? Carbon::parse($date) : now();
        return $date->copy()->addMonth()->startOfMonth();
    }

    /**
     * Get month duration for billing
     */
    public static function getMonthDuration($date = null): int
    {
        $date = $date ? Carbon::parse($date) : now();
        return $date->daysInMonth;
    }
}
