<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\MainService;

/**
 * Class MainController
 * @package App\Controllers
 * @author Junnel Miguel
 * @version 1.0
 * @since 04/09/2022
 */
class MainController extends BaseController
{
    /**
     * Function to Instantiate Request and MainService
     * @param $oRequest
     */
    public function __construct(Request $oRequest)
    {
        $this->oRequest = $oRequest;
        $this->oService = new MainService();
    }

    /**
     * Function to display data in view
     * @return Factory/view
     */
    public function index()
    {
        $aData = $this->oService->index();
        return view('main', compact('aData'));
    }

    /**
     * Function to display search result in view
     * @return Factory/view
     */
    public function search()
    {
        $aData = $this->oService->search($this->oRequest->all());
        return view('search', compact('aData'));
    }
}
