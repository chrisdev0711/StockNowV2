<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddCountToLocationSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('location.count', 0);
    }
}
