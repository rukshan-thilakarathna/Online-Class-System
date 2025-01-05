<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = $this->faker->randomElement([0, 1]); // 0 for Student, 1 for Guardian

        // If type is guardian (1), find an existing student or create a new one as a guardian
        $guardianId = 0;
        if ($type == 1) {
            // Ensure there's at least one Student in the database for guardian reference
            $guardianId = Student::where('type', 1)->inRandomOrder()->first()?->id;

            // If no guardian exists, create a new one and get its ID
            if (!$guardianId) {
                $guardianId = Student::factory()->create(['type' => 1])->id;
            }
        }

        return [
            'type' => $type,
            'guardian_id' => $type == 1 ? $guardianId : null, // Guardian should have a valid guardian_id
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->numerify('076#######'),
            'password' => Hash::make('password'), // Default password for testing
            'grade' => $this->faker->randomElement(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10' , '11', '12']),
            'whatsapp_number' => $this->faker->numerify('076#######'),
            'image' => $this->faker->imageUrl(),
            'address' => $this->faker->address(),
            'birthday' => $this->faker->date(),
            'gender' => $this->faker->randomElement([0, 1]), // 0 for Male, 1 for Female
            'status' => 1, // Active by default
        ];
    }
}
