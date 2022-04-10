<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\FileUploadService;

/**
 * Class FileUploadController
 * @package App\Controllers
 * @author Junnel Miguel
 * @version 1.0
 * @since 04/09/2022
 */
class FileUploadController extends BaseController
{
    /**
     * Function to Instantiate Request and FileUploadService
     * @param $oRequest
     */
    public function __construct(Request $oRequest)
    {
        $this->oRequest = $oRequest;
        $this->oService = new FileUploadService();
    }

    /**
     * Function to process file upload
     * @return array
     */
    public function processUploadedFile()
    {
        $oData = $this->oRequest->file('fileUpload');
        $sFilName = $oData->getClientOriginalName();
        $sFileExtension = $oData->getClientOriginalExtension();

        return $this->oService->processUploadedFile($oData, $sFilName, $sFileExtension);
    }
}
