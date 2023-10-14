<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateFormatter
{

    public static function getDatetimeFromDateAndTime(?string $date, ?string $time): ?Carbon
    {
        return $date !== null && $time !== null
            ? Carbon::parse(sprintf('%s %s', $date, $time))
            : null;
    }
}
