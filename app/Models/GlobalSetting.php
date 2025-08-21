<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalSetting extends Model
{

    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = [
        'logo_url',
    ];

    protected $casts = [
        'purchased_on' => 'datetime',
        'supported_until' => 'datetime',
        'last_license_verified_at' => 'datetime',
        'last_cron_run' => 'datetime',
    ];

    public function logoUrl(): Attribute
    {
        return Attribute::get(fn(): string => asset($this->logo ? 'user-uploads/logo/' . $this->logo : 'img/logo.png'));
    }

}
