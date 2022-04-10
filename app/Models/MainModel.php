<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class MainModel
 * @package App\Models
 * @author Junnel Miguel
 * @version 1.0
 * @since 04/09/2022
 */
class MainModel extends Model
{
    /**
     * Function to fetch all record in the database
     * @return mixed
     */
    public function getAllRecord()
    {
        return DB::table('user_tbl')->get();
    }

    /**
     * Function to fetch search result from the database
     * @return mixed
     */
    public function searchBy($whereParam)
    {
        return DB::table('user_tbl')
            ->where($whereParam)
            ->get();
    }
}
