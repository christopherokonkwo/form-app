<?php

namespace Database\Seeders;

use App\Models\IncidentReport;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\User;
use App\Models\View;
use App\Models\Visit;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Visit::factory(10)->create();
        View::factory(10)->create();
        Topic::factory(10)->create();
        Tag::factory(10)->create();
        Post::factory(10)->create();
        // IncidentReport::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
