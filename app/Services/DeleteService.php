<?php

namespace App\Services;

use Illuminate\Support\Facades\File;


class DeleteService
{

    public static function deleteFile($photoPath)
    {
        $path = null;
        if (file_exists(public_path()))
            $path = public_path($photoPath);
        else
            $path = base_path($photoPath);

        if (file_exists($path) && is_file($path))
            unlink($path);
    }

    public static function deleteAllFiles($folderPath)
    {
        $path = null;
        if (file_exists(public_path()))
            $path = public_path($folderPath);
        else
            $path = base_path($folderPath);


        if (file_exists($path)) {
            File::cleanDirectory($path);
        }
    }
}
