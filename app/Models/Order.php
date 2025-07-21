<?php

namespace App\Models;

use App\Enums\OrderEnum;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $primaryKey = 'order_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_id',
        'user_id',
        'status',
        'total_price',
        'total_amount',
        'sub_total',
    ];

    public function getStatusAttribute()
    {
        return OrderEnum::from($this->attributes['status'])->label();
    }

    public function getStatusColorAttribute()
    {
        return OrderEnum::from($this->attributes['status'])->color();
    }
    public function getUserIdAttribute()
    {
        return User::find($this->attributes['user_id'])?->name;
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'order_id', 'order_id');
    }
}
