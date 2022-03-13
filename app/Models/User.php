<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Site;
use Auth;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasFactory;
    use Searchable;
    use HasApiTokens;
    use HasProfilePhoto;
    use TwoFactorAuthenticatable;

    protected $fillable = ['name', 'email', 'password', 'owner_id', 'location_ids', 'active_site'];

    protected $searchableFields = ['*'];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }

    public function isOwner()
    {
        return $this->hasRole('owner');
    }

    public function locations()
    {
        if(Auth::user()->isOwner() || Auth::user()->isSuperAdmin())
        {
            if(!$this->location_ids)
            {
                $locations = Site::where('status', '=', true)->get();
                return $locations;
            }
        }
        $location_ids = $this->location_ids;
        $location_items = explode(';', $location_ids);
        $locations = collect();
        foreach($location_items as $location_item)
        {
            $site = Site::find($location_item);
            if($site)
                $locations->push($site);
        }

        return $locations;
    }

    public function activeLocation()    
    {
        if(Auth::user()->isOwner() || Auth::user()->isSuperAdmin())
        {
            if(!$this->active_site)
            {
                $active = Site::where('status', '=', true)->first();
                return $active;
            }
        }
        $active = Site::find($this->active_site);
        
        return $active;
    }    
}
