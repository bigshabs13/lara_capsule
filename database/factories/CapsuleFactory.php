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
            'user_id' => \App\Models\User::inRandomOrder()->first()?->id,
            'message' => $this->faker->sentence(10),
            'gps_latitude' => $this->faker->latitude,
            'gps_longitude' => $this->faker->longitude,
            'ip_address' => $this->faker->ipv4,
            'mood_id' => \App\Models\Mood::inRandomOrder()->first()?->id,
            'is_public' => $this->faker->boolean(80),
            'reveal_at' => $this->faker->dateTimeBetween('+1 days', '+1 year'),
            'revealed_at' => null,
            'country' => $this->faker->country,
        ];
    }
}
