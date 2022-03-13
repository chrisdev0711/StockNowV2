<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class LocationHookSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('location_hook.create_secret', 'bMVTEOQZBD3zYnGB0HSP_Q');
        $this->migrator->add('location_hook.update_secret', 'AOdFKpyKBCN9AzUsr_IxIQ');
    }
}
