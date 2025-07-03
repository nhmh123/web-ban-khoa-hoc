<?php

namespace App\Enums;

enum OrderEnum: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function lable(): string
    {
        return __('order_status' . $this->value);
    }
}
