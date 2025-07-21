<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'image',
        'order',
    ];

    /**
     * Get the URL of the slider image.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return asset('images/sliders/' . $this->image);
    }

    // public function setOrderAttribute($value)
    // {
    //     $maxOrder = Slider::max('order') ?? 0;
    //     $this->attributes['order'] = (int) $maxOrder + 1;
    // }
}
