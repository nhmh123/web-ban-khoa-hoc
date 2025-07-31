<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function download(Attachment $attachment)
    {
        $path = $attachment->attachment_url;
        $downloadUrl = Storage::disk("s3")->temporaryUrl($path, now()->addMinutes(60));
        return redirect($downloadUrl);
        // dd($downloadUrl);
        // return Storage::download($downloadUrl);
    }
}
