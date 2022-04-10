<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\MainModel;

/**
 * Class MainService
 * @package App\Services
 * @author Junnel Miguel
 * @version 1.0
 * @since 04/09/2022
 */
class MainService extends BaseService
{
    /**
     * Function to instantiate MainModel
     */
    public function __construct()
    {
        $this->oModel = new MainModel();
    }

    /**
     * Function to fetch all records in the database
     * @return array
     */
    public function index()
    {
        $mResult = json_decode($this->oModel->getAllRecord(), true);
        return empty($mResult) === true ? [] : $mResult; 
    }

    /**
     * Function to search data from the database
     * @param $aData
     * @return array
     */
    public function search($aData)
    {
        $bResult = $this->checkParameter($aData);

        if ($bResult === false) {
            return [];
        }

        $mResult = json_decode($this->oModel->searchBy($aData), true);
        return empty($mResult) === true ? [] : $mResult; 
    }

    /**
     * Function to check search parameters
     * @param $aData
     * @return bool
     */
    private function checkParameter($aData)
    {
        $sKey = array_key_first($aData);
        $sValue = $aData[$sKey];

        return in_array(strtolower($sKey), BaseService::FILE_HEADER) === false || $sValue === '' ? false : true;
    }
}
