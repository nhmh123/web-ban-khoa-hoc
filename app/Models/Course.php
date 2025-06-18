<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'description',
        'original_price',
        'sale_price',
        'short_description',
        'content',
        'enroll_requirements',
        'duration',
        'audience',
        'status',
        'rating',
        'cat_id',
        'language_id',
        'level_id',
        'user_id',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'duration' => 'decimal:2',
        'rating' => 'decimal:2',
    ];

    public function getDurationAttribute($value){
        return \Carbon\CarbonInterval::seconds($value)->cascade()->forHumans();
    }
    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'cat_id', 'cc_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'lang_id');
    }
    public function level()
    {
        return $this->belongsTo(DifficultyLevel::class, 'level_id', 'level_id');
    }
    public function sections()
    {
        return $this->hasMany(Section::class, 'course_id', 'id');
    }
    public function enrollments()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id');
    }
}
