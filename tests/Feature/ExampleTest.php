<?php

namespace Tests\Feature;

use App\Models\GalleryItem;
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
            'business_name' => 'Göksel Lastik',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $image = UploadedFile::fake()->image('buyuk-foto.jpg', 3200, 2400)->size(4096);

        $response = $this->actingAs($user)->postJson(route('admin.gallery.store'), [
            'images' => [$image],
            'title' => 'Test Görseli',
        ]);

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseHas('gallery_items', ['title' => 'Test Görseli']);

        $galleryItem = GalleryItem::firstOrFail();
        Storage::disk('public')->assertExists($galleryItem->image_path);
    }
}
