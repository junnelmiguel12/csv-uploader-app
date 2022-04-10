<?php

namespace App\Services;

use App\Services\BaseService;
use App\Models\FileUploadModel;

/**
 * Class FileUploadService
 * @package App\Services
 * @author Junnel Miguel
 * @version 1.0
 * @since 04/09/2022
 */
class FileUploadService extends BaseService
{
    /**
     * Variable used to set file name
     */
    private $sStoreFileName;

    /**
     * Variable used to return result
     */
    private $aResult = [];

    /**
     * Variable for upload file destination
     */
    const FILE_DESTINATION = 'excel_uploaded_files';

    /**
     * Variable for total number of header which must be present in csv file upload
     */
    const TOTAL_FILE_UPLOAD_COLUMN = 7;

    /**
     * Function to instantiate FileUploadModel
     */
    public function __construct()
    {
        $this->oModel = new FileUploadModel();
    }

    /**
     * Function to process file upload
     * @param $oData
     * @param $sFileName
     * @param $sFileExtension
     * @return array
     */
    public function processUploadedFile($oData, $sFileName, $sFileExtension)
    {
        $bIsValidFileExtension = $this->validateFileExtension($sFileExtension);

        if ($bIsValidFileExtension === false) {
            $aResult['result'] = false;
            $aResult['message'] = 'Invalid file type. Please upload excel file in csv format.';
            return $aResult;
        }

        $this->setFileName($sFileName);
        $sFilePath = $this->storeFile($oData);
        $mFileData = $this->readFile($sFilePath);

        if (is_bool($mFileData) === true) {
            $aResult['result'] = false;
            $aResult['message'] = 'Something is wrong in uploaded csv file. Please check content or format.';
            $this->removeStoredFile();
            return $aResult;
        }

        $mResult = $this->saveFileData($mFileData);

        if ($mResult === false) {
            $aResult['result'] = false;
            $aResult['message'] = 'Something went wrong while saving data in the database.';
            $this->removeStoredFile();
            return $aResult;
        }

        $this->removeStoredFile();
        
        $aResult['result'] = true;
        $aResult['message'] = 'Success';
        return $aResult;
    }

    /**
     * Function to validate file upload extension
     * @param $sFileExtension
     * @return bool
     */
    private function validateFileExtension($sFileExtension)
    {
        return in_array(strtolower($sFileExtension), array("csv")) === true ? true : false;
    }

    /**
     * Function to remove temporarily stored csv file
     */
    private function removeStoredFile()
    {
        unlink(self::FILE_DESTINATION . '/' . $this->getFileName());
    }

    /**
     * Function to store temporarily the uploaded csv file
     * @param $oData
     * @return string
     */
    private function storeFile($oData)
    {
        $oData->move(self::FILE_DESTINATION, $this->getFileName());

        return public_path(self::FILE_DESTINATION . "/" . $this->getFileName());
    }

    /**
     * Function to set name of the uploaded csv file
     * @param $sFileName
     */
    private function setFileName($sFileName)
    {
        $this->sStoreFileName = date("Ymd_hi") . '_' . $sFileName;
    }

    /**
     * Function to get name of the uploaded csv file
     * @return string
     */
    private function getFileName()
    {
        return $this->sStoreFileName;
    }

    /**
     * Function to read uploaded csv file
     * @param $sFilePath
     * @return mixed
     */
    private function readFile($sFilePath)
    {
        try {
            $mFile = fopen($sFilePath, "r");
            $aImportData = [];
            
            $iCounter = 0;
            
            while (($mFiledata = fgetcsv($mFile, 1000, ",")) !== FALSE) {
                $iTotal = count($mFiledata);

                if ($iCounter == 0) {
                    if ($this->checkFileHeader($mFiledata, $iTotal) === false) {
                        fclose($mFile);
                        return false;
                    }

                    $iCounter++;
                    continue;
                }

                for ($iCounter2 = 0; $iCounter2 < $iTotal; $iCounter2++) {
                    $aImportData[$iCounter][] = $mFiledata[$iCounter2];
                }
                
                $iCounter++;
            }
            
            fclose($mFile);
        } catch (Exception $oException) {
            return false;
        }

        return $this->checkFileData($aImportData);
    }

    /**
     * Function to check if the required headers are present in the uploaded csv file
     * @param $mFileData
     * @param $iTotal
     * @return bool
     */
    private function checkFileHeader($mFileData, $iTotal)
    {
        $mFileData = array_map('strtolower', $mFileData);
        
        return (int)$iTotal === self::TOTAL_FILE_UPLOAD_COLUMN || 
        empty(array_diff($mFileData, BaseService::FILE_HEADER)) === true ? true : false;
    }

    /**
     * Function to check if the uploaded csv file has a record
     * @param $aImportData
     * @return mixed
     */
    private function checkFileData($aImportData)
    {
        return empty($aImportData) === true ? false : $aImportData;
    }

    /**
     * Function to save data from uploaded csv file to the database
     * @param $mFileData
     * @return bool
     */
    private function saveFileData($mFileData)
    {
        $aFormattedData = $this->formatData($mFileData);
        return $this->oModel->storeFile($aFormattedData);
    }

    /**
     * Function to format data before saving it to the database
     * @param $aData
     * @return array
     */
    private function formatData($aData)
    {
        $aFormattedData = [];

        foreach($aData as $aInfo) {
            $aDetails = [];
            foreach ($aInfo as $key => $value) {
                $sKey = self::FILE_HEADER[$key];
                $aDetails[$sKey] = $value;
            }

            array_push($aFormattedData, $aDetails);
        }

        return $aFormattedData;
    }
}
