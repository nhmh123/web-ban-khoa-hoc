<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];
    public $timestamps = true;

    /**
     * Get the value of a setting by key.
     *
     * @param string $key
     * @return mixed
     */
    public static function getValue($key)
    {
        return self::where('key', $key)->value('value');
    }

    /**
     * Set the value of a setting by key.
     *
     * @param string $key
     * @param mixed $value
     */
    public static function setValue($key, $value)
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
