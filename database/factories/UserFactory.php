<?php

namespace Database\Factories;

use App\Models\{
    User,
    Category,
    AgeGroup,
    Specialty,
    WorkingStyle,
    DoctorProfile,
    Qualification,
    PatientProfile,
    SpeakingLanguage
};
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    public function definition(): array
    {
        $gender = $this->faker->randomElement(['male', 'female']);

        return [
            'name' => $this->faker->name($gender),
            'surname' => $this->faker->userName(),
            'gender' => $gender,
            'dob' => $this->faker->date('Y-m-d'),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'password' => bcrypt('123456'),
            'user_type' => 'patient',
            'email_verified_at' => $this->faker->dateTime(),
        ];
    }

    public function doctor(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return $this->state([ 'user_type' => 'doctor' ])
        ->assignRole('doctor')
        ->has(DoctorProfile::factory())
        ->hasAttached(AgeGroup::all()->random(3))->count(1)
        ->hasAttached(Qualification::all()->random(1))->count(1)
        ->hasAttached(Specialty::all()->random(3))->count(1)
        ->hasAttached(SpeakingLanguage::all()->random(2))->count(1)
        ->hasAttached(WorkingStyle::all()->random(3))->count(1)
        ->hasAttached(Category::childrensOnly()->get()->random(2))->count(1);
    }

    public function patient(): \Illuminate\Database\Eloquent\Factories\Factory
    {
        return $this->state([ 'user_type' => 'patient' ])
        ->assignRole('patient')
        ->has(PatientProfile::factory()->count(1));
    }

    private function assignRole(...$roles): UserFactory
    {
        return $this->afterCreating(fn(User $user) => $user->syncRoles($roles));
    }
}
