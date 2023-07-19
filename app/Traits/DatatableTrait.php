<?php

namespace App\Traits;

use \Illuminate\Support\Facades\Schema;

trait DatatableTrait
{
    /**
    * Get row number Yajra Datatable
    * @author moko
    * @param $primary_key string
    * @param $request array
    * @return string sql
    */
    public function addRowNum($request, $tableName=null, $orderByField=null, $order='DESC'){
        $dbType = \DB::connection()->getPdo()->getAttribute(\PDO::ATTR_DRIVER_NAME);
        
        if($dbType == 'mysql') 
        {
            \DB::statement(\DB::raw('set @rownum=0'));

            return \DB::raw('@rownum  := @rownum  + 1 AS rownum');

        } 
        else 
        {
            $tableName = $tableName ?? $this->model->getTable();
            $primKey   = $this->model->getKeyName();
            
            // orderByField variable not defined -> using created_at column as order column and if not exist -> using primary key column as order column 
            if(is_null($orderByField))
            {
                $orderByField = Schema::hasColumn($tableName, 'created_at') ? 'created_at' : $primKey;
            }
            
            // get column index frontend
            $order_column = $request->get('order')[0]['column'];

            // nomor urut
            $sql_no_urut = 'row_number() OVER (ORDER BY "' .$tableName. '"."'. $orderByField .'" '. $order .') AS rownum'; // row_number() = postgresql function
            if($order_column != 0){

                // ----------------------------
                // Yajra Datatable Index
                $yajraIndex = $request->get('columns')[$order_column];
                $fieldName  = $yajraIndex['data']; // field_name

                if(isset($yajraIndex['name'])){
                    $tableField =  $yajraIndex['name']; // table.field_name
                    $tableName  = $tableName ?? explode('.', $tableField)[0];
                    $fieldName  = $orderByField ?? explode('.', $tableField)[1];
                }

                $orderByField = $request->get('order')[0]['dir']; // asc|desc
                // ----------------------------
                
                $sql_no_urut= 'row_number() OVER (ORDER BY "'. $tableName .'"."'. $fieldName .'" '. $orderByField .') AS rownum';
            }

            return \DB::raw($sql_no_urut);
        }
        
    }

    
}