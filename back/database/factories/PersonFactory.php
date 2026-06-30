<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
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
            'email' =>  Str::random(5).str_replace('example', 'afshin', $this->faker->unique()->safeEmail),
            'email_verified_at' => now(),
            'password' => '$2y$10$BdQ9Tn.eZxuL0hKiywx6hOdYPjMmoUBnfzI7dUt8xmd8F5biNVMvi', // password
            'mobile'=>$this->faker->numerify('###########'),
            'remember_token' => Str::random(10),
            'role_id' => 2,
            'avatar' => 'users/default.png',
            'inviter' => 96,
            'settings' => '{"locale":"fa", "name":"'.$this->faker->name().'", "family":"'.$this->faker->name().'", "access":"1"}',
        ];
    }
}
