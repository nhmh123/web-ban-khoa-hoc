<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    protected $fillable = ['attachment_url', 'lec_id'];

    protected static function booted()
    {
        static::deleting(function ($attachment) {
            if ($attachment->attachment_url) {
                Storage::disk('s3')->delete($attachment->attachment_url);
            }
        });
    }
    public function getAttachmentNameAttribute()
    {
        $pathArray = explode("/", $this->attributes['attachment_url']);
        return end($pathArray);
    }
    public function lecture()
    {
        return $this->belongsTo(Lecture::class, 'lec_id');
    }
}
