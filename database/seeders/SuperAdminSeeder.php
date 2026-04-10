<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kzcore.com'],
            [
                'tenant_id' => null,
                'business_name' => 'KzCore',
                'username' => 'superadmin',
                'name' => 'Super Admin',
                'email' => 'admin@kzcore.com',
                'password' => '12345678', // otomatik hashleniyor
                'phone' => null,
                'role' => User::ROLE_SUPER_ADMIN,
            ]
        );
    }
}