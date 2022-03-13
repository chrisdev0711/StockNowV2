<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class LocationHookSettings extends Settings
{
    public string $create_secret;
    public string $update_secret;

    public static function group(): string{
        return 'location_hook';
    }
}