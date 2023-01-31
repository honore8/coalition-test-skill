<?php

namespace App\Traits;

use Exception;
use Throwable;
use Illuminate\Support\Facades\File;

/**
 * We will not use Laravel eloquent models since we will not be interacting with the database.
 * To make things easier we will just use arrays to store and retrieve data 
 * from the Json File.
 */
Trait DataStoreTrait
{
    protected $path = "";

    public function __construct()
    {
        //if the json file is not found, create it.
        $path = public_path("products.json");

        $this->path = $path;

        if (!file_exists($path)) {
            try {
                $this->createFile($path);
            } catch (\Throwable $th) {
                //handle the error creating the file here
                //leaving it empty for now.
            }
        }
    }

    private function createFile($path)
    {
        try {
            File::put($path, '');
        } catch (Throwable $th) {
            throw $th;
        }
    }

    private function getPath()
    {
        return $this->path;
    }

}
