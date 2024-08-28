<?php

namespace Database\Factories;

use App\Models\Classes;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Classes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->slug,
            'description' => $this->faker->paragraph,
            'image' => null,
            'class_type' => $this->faker->randomElement(['1', '2']),
            'class_category' => $this->faker->randomElement(['1', '2']),
            'grade' => $this->faker->randomElement(['[1]', '[2]', '[3]', '[4]', '[5]', '[6]', '[7]', '[8]', '[9]', '[10]', '[11]']),
            'class_fees' => $this->faker->randomNumber(4),
            'class_fees_date' => json_encode(['start_date' => $this->faker->date(), 'end_date' => $this->faker->date()]),
            'class_year' => $this->faker->year,
            'class_start_date' => $this->faker->date(),
            'class_date' => json_encode(['date' => $this->faker->date(), 'time' => $this->faker->time()]),
            'status' => $this->faker->randomElement(['1', '2', '3']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
