<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class VatRateSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('vat_rate.vat_rate1', 40);
        $this->migrator->add('vat_rate.vat_rate2', 20);
        $this->migrator->add('vat_rate.vat_rate3', 0);

    }
}
