<?php

namespace Database\Factories\Access;

use App\Models\Access\Role;
use Illuminate\Database\Eloquent\Factories\Factory;



class RoleFactory extends Factory
{
    protected $model = Role::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(255),
            'created_user_id' => 0,
        ];
    }   
}
