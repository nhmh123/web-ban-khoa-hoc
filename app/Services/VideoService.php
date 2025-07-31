<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class VideoService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function uploadVideoToS3Bucket($file, $path)
    {
        $filePath = $file->store($path, [
            "disk" => "s3",
            "visibility" => "private"
        ]);

        return $filePath;
    }

    public function getSignedUrl($videoPath)
    {
        $disk = Storage::disk("s3");
        $expiration = now()->addMinutes(15);
        return $disk->temporaryUrl($videoPath, $expiration);
    }
}
