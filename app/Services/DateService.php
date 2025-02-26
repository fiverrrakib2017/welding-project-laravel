<?php

namespace App\Services;

use Carbon\Carbon;

class DateService
{
    public function getStartDate($filter)
    {
        switch ($filter) {
            case 'today':
                return Carbon::today()->toDateString();
            case 'last7days':
                return Carbon::now()->subDays(7)->toDateString();
            case 'this_month':
                return Carbon::now()->startOfMonth()->toDateString();
            case 'last_month':
                return Carbon::now()->subMonth()->startOfMonth()->toDateString();
            case 'this_year':
                return Carbon::now()->startOfYear()->toDateString();
            case 'last_year':
                return Carbon::now()->subYear()->startOfYear()->toDateString();
            case 'last_two_years':
                return Carbon::now()->subYears(2)->startOfYear()->toDateString();
            default:
                return Carbon::today()->toDateString();
        }
    }

    public function getEndDate($filter)
    {
        switch ($filter) {
            case 'today':
            case 'last7days':
            case 'this_month':
            case 'this_year':
                return Carbon::now()->toDateString();
            case 'last_month':
                return Carbon::now()->subMonth()->endOfMonth()->toDateString();
            case 'last_year':
                return Carbon::now()->subYear()->endOfYear()->toDateString();
            case 'last_two_years':
                return Carbon::now()->subYears(2)->endOfYear()->toDateString();
            default:
                return Carbon::now()->toDateString();
        }
    }
}
