<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface BannerContract
 * @package App\Services\Contracts
 */
interface BannerContract
{
    /**
     * @param array $arr
     * @return Model
     */
    public function add(array $arr): Model;
}
