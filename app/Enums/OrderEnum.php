<?php

namespace App\Enums;

enum OrderEnum: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return __('order_status.' . $this->value);
    }

    public function color(): string{
        return match($this){
            self::PENDING => 'badge-warning',
            self::COMPLETED => 'badge-success',
            self::CANCELLED => 'badge-dark',
        };
    }
}
