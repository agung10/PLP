<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

trait StorageTrait
{
    
    public function upload($files, $insertedRecord)
    {
        $upload    = false;
        $tableName = $this->model->getTable();
        $primKey   = $this->model->getKeyName();

        foreach ($files as $key => $file) {
            $oldFile         = array_key_exists('old_file', $file) ? $file['old_file'] : null;
            $image           = $file['file'];
            $imagename       = $file['name'].'_'. $insertedRecord->$primKey . '_'. time() . '.' . $image->getClientOriginalExtension();

            $this->update([$file['name'] => $imagename], $insertedRecord->$primKey);

            // upload files
            $upload = $this->storeFile($image, $tableName, $imagename, $oldFile);
            
        }

        return $upload;
    }

    public function storeFile($image, $destinationPath, $imagename, $oldName)
    {
        if($oldName) Storage::delete($destinationPath.'/'.$oldName);

        Storage::putFileAs($destinationPath,$image, $imagename);

        return Storage::exists($destinationPath.'/'.$imagename);
    }

    public function deleteFile($path)
    {
        $exist  = Storage::exists($path);
        if($exist) Storage::delete($path);

        return $exist;
    }

    /**
    * Download backup from corresponding filesystem
    * @param $path
    * @param $filesystem custom filesystem
    * @return file download of backup file
    */
    public function downloadFile($path)
    {
        return Storage::download($path);
    }

    /**
    * get file size of backup file from corresponding disk
    * @param $backupId
    * @return file size of backup file
    */
    public function sizeFile($path)
    {
        $size = Storage::size($path);
        
        return \Helper::bytesToHuman($size);
    }

}