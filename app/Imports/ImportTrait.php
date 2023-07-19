<?php

namespace App\Imports;

trait ImportTrait
{
    
    /**
     * Transform a date value into a Carbon object.
     *
     * @return \Carbon\Carbon|null
     */
    public function transformDate($value, $format = 'Y-m-d')
    {
        if(is_null($value) || is_string($value)) return null;

        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }

    /**
     * Prevent invalid input from excel to database
     *
     * @return suitable value
     */
    public function onlyAllowNumeric($value)
    {
        switch (true) {
            case (strpos($value, '%') !== false):
                $return = str_replace('.', ',', $value);
                $return = str_replace('%', '', $value);
                $return = (float) $return / 100;

                return $return;
            case (strpos($value, ',') !== false):
                return str_replace(',', '.', $value);
            case (is_string($value)):
                return 0;
            case (is_null($value)):
                return 0;
            default:
                return $value;
        }
    }
}