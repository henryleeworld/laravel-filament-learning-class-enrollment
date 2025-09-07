<?php

namespace Database\Factories;

use App\Models\ClassType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LearningClass>
 */
class LearningClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $classNames = [
            __('Humanities'),
            __('Social sciences'),
            __('Natural sciences'),
            __('Sustainability practice'),
            __('Introduction to computer science'),
            __('Discrete mathematics'),
            __('Linear algebra'),
            __('Logic design'),
            __('Logic design laboratory'),
            __('C++ programming'),
            __('Probability'),
            __('Data structures'),
            __('Introduction to machine learning'),
            __('Systems programming'),
            __('Computer networks'),
            __('Computer organization'),
            __('Algorithms'),
            __('Operating system'),
        ];

        return [
            'class_type_id' => ClassType::inRandomOrder()->first()->id,
            'name' => fake()->randomElement($classNames),
            'description' => fake()->paragraph(),
            'price_per_student' => fake()->randomNumber(4, true),
        ];
    }
}
