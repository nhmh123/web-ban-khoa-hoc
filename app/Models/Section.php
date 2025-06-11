<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'duration',
        'description',
        'course_id',
        'order',
    ];

    protected $primaryKey = 'sec_id';

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
