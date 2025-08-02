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

    public function getDurationAttribute($value)
    {
        // return \Carbon\CarbonInterval::seconds($value)->cascade()->forHumans(true);
        $hours = floor($value / 3600);
        $minutes = floor(($value % 3600) / 60);

        $hoursString = ($hours) > 0 ? "{$hours} giờ" : "";
        $minutesString = ($minutes > 0) ? "{$minutes} phút" : "";

        return trim($hoursString . " " . $minutesString);
    }
    public function getDurationRawAttribute()
    {
        return $this->attributes['duration'];
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function lectures()
    {
        return $this->hasMany(Lecture::class, 'sec_id', 'sec_id');
    }
}
