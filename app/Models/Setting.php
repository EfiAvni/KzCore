<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Setting extends Model
{
    protected $fillable = ['tenant_id', 'key', 'value'];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function scopeForTenant(Builder $query, ?int $tenantId): Builder
    {
        return $query->where('tenant_id', $tenantId);
    }

    public static function resolveTenantId(?int $tenantId = null): ?int
    {
        return $tenantId ?? Auth::user()?->tenant_id ?? 1;
    }

    public static function allForTenant(?int $tenantId = null): array
    {
        return static::query()
            ->forTenant(static::resolveTenantId($tenantId))
            ->pluck('value', 'key')
            ->toArray();
    }

    public static function getForTenant(string $key, ?int $tenantId = null, mixed $default = null): mixed
    {
        return static::query()
            ->forTenant(static::resolveTenantId($tenantId))
            ->where('key', $key)
            ->value('value') ?? $default;
    }

    public static function updateForTenant(string $key, mixed $value, ?int $tenantId = null): self
    {
        return static::query()->updateOrCreate(
            [
                'tenant_id' => static::resolveTenantId($tenantId),
                'key' => $key,
            ],
            [
                'value' => $value,
            ],
        );
    }
}
