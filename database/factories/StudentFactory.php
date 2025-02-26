<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'birth_date' => $this->faker->date,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'father_name' => $this->faker->name('male'),
            'mother_name' => $this->faker->name('female'),
            'guardian_name' => $this->faker->name('female'),
            'photo' => $this->faker->imageUrl(640, 480, 'animals', true),
            'current_address' => $this->faker->address,
            'permanent_address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'phone_2' => $this->faker->phoneNumber,
            'current_class' =>$this->faker->numberBetween(1, 5), 
            'section_id' => $this->faker->numberBetween(1, 3),
            'previous_school' => $this->faker->sentence,
            'academic_results' => '4.50',
            'blood_group' => 'A+',
            'health_conditions' => 'Good health',
            'emergency_contact_name' => $this->faker->name,
            'emergency_contact_phone' => $this->faker->phoneNumber,
            'religion' => 'Islam',
            'nationality' => 'Bangladeshi',
            'remarks' => 'N/A',
        ];
    }
}
