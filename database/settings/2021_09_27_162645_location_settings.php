<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class LocationSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('location.id1', '');
        $this->migrator->add('location.id2', '');
        $this->migrator->add('location.id3', '');
        $this->migrator->add('location.id4', '');

        $this->migrator->add('location.name1', '');
        $this->migrator->add('location.name2', '');
        $this->migrator->add('location.name3', '');
        $this->migrator->add('location.name4', '');

        $this->migrator->add('location.address1', '');
        $this->migrator->add('location.address2', '');
        $this->migrator->add('location.address3', '');
        $this->migrator->add('location.address4', '');

        $this->migrator->add('location.locality1', '');
        $this->migrator->add('location.locality2', '');
        $this->migrator->add('location.locality3', '');
        $this->migrator->add('location.locality4', '');

        $this->migrator->add('location.postalCode1', '');
        $this->migrator->add('location.postalCode2', '');
        $this->migrator->add('location.postalCode3', '');
        $this->migrator->add('location.postalCode4', '');

        $this->migrator->add('location.status1', '');
        $this->migrator->add('location.status2', '');
        $this->migrator->add('location.status3', '');
        $this->migrator->add('location.status4', '');

        $this->migrator->add('location.country1', '');
        $this->migrator->add('location.country2', '');
        $this->migrator->add('location.country3', '');
        $this->migrator->add('location.country4', '');

        $this->migrator->add('location.languageCode1', '');
        $this->migrator->add('location.languageCode2', '');
        $this->migrator->add('location.languageCode3', '');
        $this->migrator->add('location.languageCode4', '');

        $this->migrator->add('location.merchantId1', '');
        $this->migrator->add('location.merchantId2', '');
        $this->migrator->add('location.merchantId3', '');
        $this->migrator->add('location.merchantId4', '');
        
        $this->migrator->add('location.currency1', '');
        $this->migrator->add('location.currency2', '');
        $this->migrator->add('location.currency3', '');
        $this->migrator->add('location.currency4', '');

        $this->migrator->add('location.phoneNumber1', '');
        $this->migrator->add('location.phoneNumber2', '');
        $this->migrator->add('location.phoneNumber3', '');
        $this->migrator->add('location.phoneNumber4', '');

        $this->migrator->add('location.businessName1', '');
        $this->migrator->add('location.businessName2', '');
        $this->migrator->add('location.businessName3', '');
        $this->migrator->add('location.businessName4', '');

        $this->migrator->add('location.logoUrl1', '');
        $this->migrator->add('location.logoUrl2', '');
        $this->migrator->add('location.logoUrl3', '');
        $this->migrator->add('location.logoUrl4', '');
    }
}
