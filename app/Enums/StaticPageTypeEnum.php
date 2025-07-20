<?php

namespace App\Enums;

enum StaticPageTypeEnum: string
{
    case COMPANY = 'company';
    case LEGAL = 'legal';

    // public function label(): string
    // {
    //     return __('static_page_type.' . $this->value);
    // }

    public function label(): string
    {
        return match($this) {
            self::COMPANY => 'Công ty',
            self::LEGAL => 'Pháp lý',
        };
    }
}
