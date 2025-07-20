<?php

namespace App\Helpers;

class ApiHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function error(
        string $title,
        int $status,
        string $detail = '',
        string $code = '',
        string $type = '',
    ) {
        return response()->json([
            'type' => $type ?: 'https://yourapi.com/docs/errors/' . ($code ?: 'unknown-error'),
            'title' => $title,
            'status' => $status,
            'detail' => $detail,
            'code' => $code,
        ], $status);
    }
}
