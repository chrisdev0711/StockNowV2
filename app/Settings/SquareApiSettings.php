<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SquareApiSettings extends Settings
{
    public string $app_id;
    public string $access_token;

    public static function group(): string{
        return 'square_api';
    }
}