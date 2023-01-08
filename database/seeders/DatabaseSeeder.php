<?php

namespace Database\Seeders;

use App\Filament\Resources\Shop\OrderResource;
use App\Models\Address;
use App\Models\Blog\Author;
use App\Models\Blog\Category as BlogCategory;
use App\Models\Blog\Post;
use App\Models\Comment;
use App\Models\Shop\Brand;
use App\Models\Shop\Category as ShopCategory;
use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\Shop\Payment;
use App\Models\Shop\Product;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    const IMAGE_URL = 'https://source.unsplash.com/random/200x200/?img=1';

    public function run(): void
    {
        // Clear images
        Storage::deleteDirectory('public');

        // $user = User::factory()->create([
        //     'name' => 'Demo User',
        //     'email' => 'demo@filamentphp.com',
        // ]);
        // $this->command->info('Demo user created.');

        // Blog
        $blogCategories = BlogCategory::factory()->count(1)->create();
        $this->command->info('Blog categories created.');

        Author::factory()->count(1)
            ->has(
                Post::factory()->count(1)
                    ->state(fn (array $attributes, Author $author) => ['blog_category_id' => $blogCategories->random(1)->first()->id]),
                'posts'
            )
            ->create();
        $this->command->info('Blog authors and posts created.');

        $this->call(RolesAndPermissionsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
    }
}
