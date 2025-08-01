<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'rating',
        'comment',
    ];

    /**
     * Người dùng đã viết đánh giá
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Khóa học được đánh giá
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
