<?php

namespace App\Enums;

use Carbon\Carbon;

/**
 * Class DateFormat
 * @package App\Enums
 */
class DateFormat
{
    /** @var string  */
    public const RETRIEVE = 'd-m-Y';

    /** @var string  */
    public const STORE = 'Y-m-d';

    /**
     * @param $date
     * @return string
     */
    public static function store($date)
    {
        return Carbon::createFromFormat(self::STORE, $date)->format(self::STORE);
    }

    /**
     * @param $date
     * @return string
     */
    public static function retrieve($date)
    {
        return Carbon::createFromFormat(self::STORE, $date)->format(self::RETRIEVE);
    }
}
