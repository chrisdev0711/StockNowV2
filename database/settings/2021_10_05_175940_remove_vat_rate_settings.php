<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class RemoveVatRateSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->delete('vat_rate.vat_rate1');
        $this->migrator->delete('vat_rate.vat_rate2');
        $this->migrator->delete('vat_rate.vat_rate3');
        $this->migrator->delete('vat_rate.count');
    }
}
