<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function uploadFile($file)
    {
        $url = Storage::putFile('public/company/logo', $file);
        return Storage::url($url);
    }
}
