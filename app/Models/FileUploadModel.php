<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class FileUploadModel
 * @package App\Models
 * @author Junnel Miguel
 * @version 1.0
 * @since 04/09/2022
 */
class FileUploadModel extends Model
{
    /**
     * Function to store csv data to the database
     * @return bool
     */
    public function storeFile($aData)
    {
        $this->truncateTable();
        return DB::table('user_tbl')->insert($aData);
    }

    /**
     * Function to empty table before storing new data from csv upload
     * @return bool
     */
    private function truncateTable()
    {
        return DB::table('user_tbl')->truncate();
    }
}
