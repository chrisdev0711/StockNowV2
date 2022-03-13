<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class SquareApiSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('square_api.app_id', 'sq0idp-wH1dbL_ywT99Ee-Exnu1xQ');
        $this->migrator->add('square_api.access_token', '');
    }
}
