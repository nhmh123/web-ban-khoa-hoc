<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['attachment_url', 'lec_id'];

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
