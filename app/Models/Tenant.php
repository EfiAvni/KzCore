<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'domain',
        'panel_path',
        'status',
        'package_name',
        'theme_code',
    ];

    protected static function booted(): void
    {
        static::creating(function (Tenant $tenant) {
            if (blank($tenant->slug)) {
                $tenant->slug = Str::slug($tenant->name);
            }

            if (blank($tenant->panel_path)) {
                $tenant->panel_path = '/admin';
            }

            if (blank($tenant->theme_code)) {
                $tenant->theme_code = 'classic';
            }
        });
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(GalleryItem::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    public function domains(): HasMany
    {
        return $this->hasMany(TenantDomain::class);
    }
}
