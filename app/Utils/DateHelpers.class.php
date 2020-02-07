<?php
namespace Utils;

use Carbon\Carbon;

class DateHelpers
{
    public function dateBR($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }
    
    public function dateTimeBR($date)
    {
        return Carbon::parse($date)->format('d/m/Y H:i:s');
    }
}