<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$BdQ9Tn.eZxuL0hKiywx6hOdYPjMmoUBnfzI7dUt8xmd8F5biNVMvi', // password
            'mobile'=>$faker->numerify('###########'),
            'remember_token' => Str::random(10),
            'role_id' => 2,
            'avatar' => 'users/default.png',
            'inviter' => 24,
            'settings' => '{"locale":"fa", "name":"'.$this->faker->name().'", "family":"'.$this->faker->name().'", "access":"1"}',
        ];
    }
}
