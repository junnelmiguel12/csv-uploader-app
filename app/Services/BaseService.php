<?php

namespace App\Services;

/**
 * Class BaseService
 * @package App\Services
 * @author Junnel Miguel
 * @version 1.0
 * @since 04/09/2022
 */
class BaseService
{
    /**
     * Object variable for model
     */
    protected $oModel;

    /**
     * Variable that store csv headers, column names
     */
    const FILE_HEADER = ['year','rank','recipient','country','career','tied','title'];
}
