<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    protected $primaryKey = 'video_id';

    protected $fillable = [
        'video_url',
        'duration',
        'lec_id',
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class, 'lec_id', 'lec_id');
    }
}
