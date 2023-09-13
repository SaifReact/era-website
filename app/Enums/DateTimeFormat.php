<?php

namespace App\Enums;

use Carbon\Carbon;

/**
 * Class DateTimeFormat
 * @package App\Enums
 */
class DateTimeFormat
{
    /** @var string  */
    public const RETRIEVE = 'd-m-Y H:i';

    /** @var string  */
    public const STORE = 'Y-m-d H:i';

    /**
     * @param $datetime
     * @return string
     */
    public static function store($datetime)
    {
        return Carbon::createFromFormat(self::STORE, $datetime)->format(self::STORE);
    }

    /**
     * @param $datetime
     * @return string
     */
    public static function retrieve($datetime)
    {
        return Carbon::createFromFormat(self::RETRIEVE, $datetime)->format(self::RETRIEVE);
    }
}
