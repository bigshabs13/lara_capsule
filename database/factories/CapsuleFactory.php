<?php

namespace Database\Factories;

use App\Models\Capsule;
use App\Models\User;
use App\Models\Mood;
use Illuminate\Database\Eloquent\Factories\Factory;

class CapsuleFactory extends Factory
{
    protected $model = Capsule::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // or pick an existing user ID
            'message' => $this->faker->sentence(10),
            'gps_latitude' => $this->faker->latitude,
            'gps_longitude' => $this->faker->longitude,
            'ip_address' => $this->faker->ipv4,
            'mood_id' => Mood::inRandomOrder()->first()?->id, // or null
            'is_public' => $this->faker->boolean(80),
            'reveal_at' => $this->faker->dateTimeBetween('+1 days', '+1 year'),
            'revealed_at' => null,
            'country' => $this->faker->country,
        ];
    }
}
