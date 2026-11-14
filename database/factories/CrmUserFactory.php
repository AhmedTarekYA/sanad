<?php

namespace Database\Factories;

use App\Models\CRM\CrmUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<CrmUser>
 */
class CrmUserFactory extends Factory
{
    protected $model = CrmUser::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'subscription_ends_at' => now()->addYear(),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => false,
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes): array => [
            'subscription_ends_at' => now()->subDay(),
        ]);
    }
}
