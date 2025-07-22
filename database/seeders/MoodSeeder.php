<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mood;

class MoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $moods = [
            'Joyful', 'Hopeful', 'Grateful', 'Nostalgic', 'Excited',
            'Motivated', 'Curious', 'Reflective', 'Calm', 'Inspired',
            'Anxious', 'Melancholic', 'Confident', 'Determined', 'Content',
            'Sad', 'Goofy', 'Lonely', 'Angry', 'Peaceful'
        ];

        foreach ($moods as $mood) {
            Mood::firstOrCreate(['name' => $mood]);
        }
    }
}
