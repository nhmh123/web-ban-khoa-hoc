<?php

namespace App\Models;

use App\Enums\LectureEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Lecture extends Model
{
    protected $table = 'lectures';

    protected $primaryKey = 'lec_id';

    protected $fillable = [
        'title',
        'slug',
        'is_intro',
        'type',
        'order',
        'sec_id',
    ];

    protected static function booted()
    {
        static::deleting(function ($lecture) {
            // dd($lecture->duration_raw, $lecture->section['duration'], $lecture->section->course->duration_raw);
            if ($lecture->type == LectureEnum::VIDEO->value) {
                $video = $lecture->video;
                if ($video->video_url) {
                    Storage::disk('s3')->delete($video->video_url);
                }

                $duration = (int) $lecture->duration_raw;
                if ($lecture->section) {
                    $lecture->section->update([
                        'duration' => $lecture->section->duration_raw - $duration
                    ]);

                    if ($lecture->section->course) {
                        $lecture->section->course->update([
                            'duration' => $lecture->section->course->duration_raw - $duration
                        ]);
                    }
                }
            };

            if ($lecture->attachments) {
                $lecture->attachments->each->delete();
            }
        });

        // static::updated(function ($lecture) {
        //     $duration = (int) $lecture->duration_raw;
        //     if ($lecture->section) {
        //         $lecture->section->update([
        //             'duration' => $lecture->section->duration_raw - $duration
        //         ]);

        //         if ($lecture->section->course) {
        //             $lecture->section->course->update([
        //                 'duration' => $lecture->section->course->duration_raw - $duration
        //             ]);
        //         }
        //     }
        // });
    }

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
    public function section()
    {
        return $this->belongsTo(Section::class, 'sec_id', 'sec_id');
    }

    public function video()
    {
        return $this->hasOne(Video::class, 'lec_id', 'lec_id');
    }
    public function article()
    {
        return $this->hasOne(Article::class, 'lec_id', 'lec_id');
    }
    public function notes()
    {
        return $this->hasMany(Note::class, 'lec_id', 'lec_id');
    }
    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'lec_id');
    }
    public function user_progress()
    {
        return $this->belongsToMany(User::class, 'user_lecture_progress', 'lec_id', 'user_id')->withPivot('progress');
    }
}
