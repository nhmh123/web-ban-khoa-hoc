<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function getDurationAttribute($value)
    {
        return \Carbon\CarbonInterval::seconds($value)->cascade()->forHumans();
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
