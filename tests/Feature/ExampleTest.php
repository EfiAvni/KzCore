<?php

namespace Tests\Feature;

use App\Models\GalleryItem;
use App\Models\Setting;
use App\Models\Tenant;
use App\Models\TenantDomain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_gallery_upload_accepts_large_dimensions_and_optimizes_image(): void
    {
        Storage::fake('public');

        $user = User::create([
            'tenant_id' => 1,
            'business_name' => 'Göksel Lastik',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_TENANT_ADMIN,
        ]);

        $image = UploadedFile::fake()->image('buyuk-foto.jpg', 3200, 2400)->size(4096);

        $response = $this->actingAs($user)->postJson(route('admin.gallery.store'), [
            'images' => [$image],
            'title' => 'Test Görseli',
        ]);

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseHas('gallery_items', ['tenant_id' => 1, 'title' => 'Test Görseli']);

        $galleryItem = GalleryItem::firstOrFail();
        Storage::disk('public')->assertExists($galleryItem->image_path);
    }

    public function test_settings_are_retrieved_per_tenant(): void
    {
        Setting::create([
            'tenant_id' => 1,
            'key' => 'theme_color',
            'value' => '#111111',
        ]);

        Setting::create([
            'tenant_id' => 2,
            'key' => 'theme_color',
            'value' => '#222222',
        ]);

        $this->assertSame('#111111', Setting::getForTenant('theme_color', 1));
        $this->assertSame('#222222', Setting::getForTenant('theme_color', 2));
        $this->assertSame('#111111', Setting::allForTenant(1)['theme_color']);
        $this->assertSame('#222222', Setting::allForTenant(2)['theme_color']);
    }

    public function test_super_admin_is_redirected_to_kzcore_after_login(): void
    {
        User::create([
            'tenant_id' => 1,
            'business_name' => 'Kucukzade Digital',
            'username' => 'super-admin',
            'email' => 'super-admin@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_SUPER_ADMIN,
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'super-admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('kzcore.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_tenant_admin_is_redirected_to_tenant_dashboard_after_login(): void
    {
        User::create([
            'tenant_id' => 1,
            'business_name' => 'Goksel Lastik',
            'username' => 'tenant-admin',
            'email' => 'tenant-admin@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_TENANT_ADMIN,
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'tenant-admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_tenant_admin_only_sees_own_gallery_items_in_panel(): void
    {
        $user = User::create([
            'tenant_id' => 1,
            'business_name' => 'Goksel Lastik',
            'username' => 'tenant-admin',
            'email' => 'tenant-gallery@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_TENANT_ADMIN,
        ]);

        GalleryItem::create([
            'tenant_id' => 1,
            'image_path' => 'gallery/tenant-1.webp',
            'title' => 'Tenant One Gallery',
        ]);

        GalleryItem::create([
            'tenant_id' => 2,
            'image_path' => 'gallery/tenant-2.webp',
            'title' => 'Tenant Two Gallery',
        ]);

        $response = $this->actingAs($user)->get(route('admin.gallery'));

        $response->assertOk();
        $response->assertSee('Tenant One Gallery');
        $response->assertDontSee('Tenant Two Gallery');
    }

    public function test_tenant_admin_cannot_delete_another_tenant_gallery_item(): void
    {
        Storage::fake('public');

        $user = User::create([
            'tenant_id' => 1,
            'business_name' => 'Goksel Lastik',
            'username' => 'tenant-admin',
            'email' => 'tenant-gallery-delete@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_TENANT_ADMIN,
        ]);

        $galleryItem = GalleryItem::create([
            'tenant_id' => 2,
            'image_path' => 'gallery/foreign.webp',
            'title' => 'Foreign Gallery',
        ]);

        $response = $this->actingAs($user)->delete(route('admin.gallery.destroy', $galleryItem->id));

        $response->assertNotFound();
        $this->assertDatabaseHas('gallery_items', ['id' => $galleryItem->id, 'tenant_id' => 2]);
    }

    public function test_tenant_admin_only_sees_own_settings_and_users_in_panel(): void
    {
        $user = User::create([
            'tenant_id' => 1,
            'business_name' => 'Goksel Lastik',
            'username' => 'tenant-admin',
            'email' => 'tenant-settings@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_TENANT_ADMIN,
        ]);

        User::create([
            'tenant_id' => 2,
            'business_name' => 'Other Tenant',
            'username' => 'other-tenant-user',
            'email' => 'other-tenant-user@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_TENANT_ADMIN,
        ]);

        Setting::create([
            'tenant_id' => 1,
            'key' => 'theme_color',
            'value' => '#111111',
        ]);

        Setting::create([
            'tenant_id' => 2,
            'key' => 'theme_color',
            'value' => '#222222',
        ]);

        $response = $this->actingAs($user)->get(route('admin.settings'));

        $response->assertOk();
        $response->assertSee('tenant-admin');
        $response->assertDontSee('other-tenant-user');
        $response->assertSee('#111111');
        $response->assertDontSee('#222222');
    }

    public function test_tenant_admin_updates_only_own_settings(): void
    {
        $user = User::create([
            'tenant_id' => 1,
            'business_name' => 'Goksel Lastik',
            'username' => 'tenant-admin',
            'email' => 'tenant-settings-update@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_TENANT_ADMIN,
        ]);

        Setting::create([
            'tenant_id' => 1,
            'key' => 'theme_color',
            'value' => '#111111',
        ]);

        Setting::create([
            'tenant_id' => 2,
            'key' => 'theme_color',
            'value' => '#222222',
        ]);

        $response = $this->actingAs($user)->post(route('admin.settings.update'), [
            'theme_color' => '#abcdef',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('settings', ['tenant_id' => 1, 'key' => 'theme_color', 'value' => '#abcdef']);
        $this->assertDatabaseHas('settings', ['tenant_id' => 2, 'key' => 'theme_color', 'value' => '#222222']);
    }

    public function test_tenant_admin_cannot_delete_another_tenant_user(): void
    {
        $user = User::create([
            'tenant_id' => 1,
            'business_name' => 'Goksel Lastik',
            'username' => 'tenant-admin',
            'email' => 'tenant-user-delete@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_TENANT_ADMIN,
        ]);

        $foreignUser = User::create([
            'tenant_id' => 2,
            'business_name' => 'Other Tenant',
            'username' => 'foreign-user',
            'email' => 'foreign-user@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_TENANT_ADMIN,
        ]);

        $response = $this->actingAs($user)->delete(route('admin.users.destroy', $foreignUser->id));

        $response->assertNotFound();
        $this->assertDatabaseHas('users', ['id' => $foreignUser->id, 'tenant_id' => 2]);
    }

    public function test_super_admin_can_access_kzcore_dashboard(): void
    {
        $superAdmin = User::create([
            'tenant_id' => 1,
            'business_name' => 'Kucukzade Digital',
            'username' => 'super-admin',
            'email' => 'super-access@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_SUPER_ADMIN,
        ]);

        $tenant = Tenant::create([
            'name' => 'Tenant One',
            'slug' => 'tenant-one',
            'domain' => 'tenant-one.test',
            'panel_path' => '/admin',
            'status' => 'active',
            'package_name' => 'premium',
        ]);

        $response = $this->actingAs($superAdmin)->get(route('kzcore.dashboard'));

        $response->assertOk();
        $response->assertSee('Tenant Yonetim Alani');
        $response->assertSee($tenant->name);
    }

    public function test_tenant_admin_is_redirected_away_from_kzcore_dashboard(): void
    {
        $tenantAdmin = User::create([
            'tenant_id' => 1,
            'business_name' => 'Goksel Lastik',
            'username' => 'tenant-admin',
            'email' => 'tenant-no-kzcore@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_TENANT_ADMIN,
        ]);

        $response = $this->actingAs($tenantAdmin)->get(route('kzcore.dashboard'));

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_super_admin_can_create_tenant_and_tenant_user(): void
    {
        $superAdmin = User::create([
            'tenant_id' => 1,
            'business_name' => 'Kucukzade Digital',
            'username' => 'super-admin',
            'email' => 'super-create@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_SUPER_ADMIN,
        ]);

        $createTenantResponse = $this->actingAs($superAdmin)->post(route('kzcore.tenants.store'), [
            'name' => 'New Tenant',
            'slug' => 'new-tenant',
            'domain' => 'new-tenant.test',
            'panel_path' => '/admin',
            'status' => 'active',
            'package_name' => 'premium',
            'admin_username' => 'tenant-owner',
            'admin_email' => 'tenant-owner@example.com',
            'admin_password' => 'password',
            'admin_phone' => '5551234567',
            'theme_color' => '#112233',
            'settings_email' => 'iletisim@new-tenant.test',
            'address' => 'Test Mahallesi No: 1',
            'phone_1' => '5550001111',
        ]);

        $createTenantResponse->assertRedirect();
        $this->assertDatabaseHas('tenants', [
            'name' => 'New Tenant',
            'slug' => 'new-tenant',
            'domain' => 'new-tenant.test',
            'panel_path' => '/admin',
            'status' => 'active',
            'package_name' => 'premium',
        ]);

        $tenant = Tenant::where('domain', 'new-tenant.test')->firstOrFail();
        $this->assertDatabaseHas('users', [
            'tenant_id' => $tenant->id,
            'username' => 'tenant-owner',
            'email' => 'tenant-owner@example.com',
            'role' => User::ROLE_TENANT_ADMIN,
        ]);
        $this->assertDatabaseHas('tenant_domains', [
            'tenant_id' => $tenant->id,
            'domain' => 'new-tenant.test',
            'is_primary' => 1,
        ]);
        $this->assertTrue(TenantDomain::query()->where('tenant_id', $tenant->id)->where('domain', 'new-tenant.test')->exists());
        $this->assertDatabaseHas('settings', [
            'tenant_id' => $tenant->id,
            'key' => 'theme_color',
            'value' => '#112233',
        ]);
        $this->assertDatabaseHas('settings', [
            'tenant_id' => $tenant->id,
            'key' => 'email',
            'value' => 'iletisim@new-tenant.test',
        ]);
        $this->assertDatabaseHas('settings', [
            'tenant_id' => $tenant->id,
            'key' => 'address',
            'value' => 'Test Mahallesi No: 1',
        ]);
        $this->assertDatabaseHas('settings', [
            'tenant_id' => $tenant->id,
            'key' => 'phone_1',
            'value' => '5550001111',
        ]);
        $this->assertDatabaseHas('settings', [
            'tenant_id' => $tenant->id,
            'key' => 'site_logo',
            'value' => '',
        ]);
    }
}
