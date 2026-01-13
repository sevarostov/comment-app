<?php

namespace Database\Seeders;

use App\Models\VideoPost;
use Illuminate\Database\Seeder;

class VideoPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		VideoPost::factory(500)->create();
    }
}
