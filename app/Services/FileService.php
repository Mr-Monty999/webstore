<?php

namespace App\Services;

use Directory;
use File;
use Illuminate\Support\Facades\File as FacadesFile;

/**
 * Class FileService.
 */
class FileService
{

    public static function uploadFile($file, $publicPath)
    {
        self::initDirectoriesIfNotExists();
        $newFileName = time() . "." . $file->getClientOriginalExtension();
        $file->move(self::getStoragePath($publicPath), $newFileName);
        return $publicPath . "/" . $newFileName;
    }
    public static function getStoragePath($path = null)
    {
        if ($path != null)
            return public_path("storage/$path");
        else
            return public_path("storage");
    }
    public static function deleteFile($filePublicPath)
    {

        if (file_exists(self::getStoragePath($filePublicPath) && is_file(self::getStoragePath($filePublicPath))))
            unlink(self::getStoragePath($filePublicPath));

        return true;
    }
    public static function cleanDirectory($path)
    {
        if (file_exists(self::getStoragePath($path)))
            File::cleanDirectory(self::getStoragePath($path));
        return true;
    }
    public static function deleteFiles(array $files)
    {
        foreach ($files as $file) {
            self::deleteFile($file);
        }
        return true;
    }
    public static function initDirectoriesIfNotExists()
    {
        if (!file_exists(self::getStoragePath()))
            mkdir(self::getStoragePath());
        if (!file_exists(self::getStoragePath("users")))
            mkdir(self::getStoragePath("users"));
        if (!file_exists(self::getStoragePath("settings")))
            mkdir(self::getStoragePath("settings"));
        if (!file_exists(self::getStoragePath("products")))
            mkdir(self::getStoragePath("products"));
        if (!file_exists(self::getStoragePath("items")))
            mkdir(self::getStoragePath("items"));

        return true;
    }
}
