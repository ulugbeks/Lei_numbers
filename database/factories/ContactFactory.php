<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        $plans = ['1-year', '3-years', '5-years'];
        $selectedPlan = $this->faker->randomElement($plans);
        $amounts = [
            '1-year' => 75.00,
            '3-years' => 195.00,
            '5-years' => 275.00
        ];
        
        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['registration', 'renewal', 'transfer']),
            'country' => $this->faker->countryCode,
            'full_name' => $this->faker->name,
            'legal_entity_name' => $this->faker->company,
            'registration_id' => strtoupper($this->faker->countryCode . $this->faker->numerify('##') . $this->faker->bothify('????###???##########')),
            'email' => $this->faker->companyEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'zip_code' => $this->faker->postcode,
            'selected_plan' => $selectedPlan,
            'amount' => $amounts[$selectedPlan],
            'same_address' => $this->faker->boolean(80),
            'private_controlled' => $this->faker->boolean(30),
            'payment_status' => $this->faker->randomElement(['paid', 'pending', 'failed']),
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => function (array $attributes) {
                return $attributes['created_at'];
            },
        ];
    }

    /**
     * Indicate that the LEI is paid.
     */
    public function paid()
    {
        return $this->state(function (array $attributes) {
            return [
                'payment_status' => 'paid',
            ];
        });
    }

    /**
     * Indicate that the LEI is pending payment.
     */
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'payment_status' => 'pending',
            ];
        });
    }

    /**
     * Indicate that this is a registration.
     */
    public function registration()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'registration',
            ];
        });
    }

    /**
     * Indicate that this is a renewal.
     */
    public function renewal()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'renewal',
            ];
        });
    }

    /**
     * Indicate that this is a transfer.
     */
    public function transfer()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'transfer',
            ];
        });
    }
}