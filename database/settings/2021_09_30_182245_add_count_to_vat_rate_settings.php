<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddCountToVatRateSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('vat_rate.count', 0);
    }
}
