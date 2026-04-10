<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_TENANT_ADMIN = 'tenant_admin';

    protected $fillable = [
        'tenant_id',
        'business_name',
        'username',
        'email',
        'password',
        'phone',
        'role',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function scopeForTenant(Builder $query, ?int $tenantId): Builder
    {
        return $query->where('tenant_id', $tenantId);
    }

    public static function roles(): array
    {
        return [
            self::ROLE_SUPER_ADMIN,
            self::ROLE_TENANT_ADMIN,
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isTenantAdmin(): bool
    {
        return $this->role === self::ROLE_TENANT_ADMIN;
    }

    public function getRoleLabel(): string
    {
        return $this->isSuperAdmin() ? 'Super Admin' : 'Tenant Admin';
    }
}
