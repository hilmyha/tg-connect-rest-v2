<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warga>
 */
class WargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_kk' => $this->faker->name(),
            'blok' => $this->faker->randomLetter,
            'jalan' => $this->faker->streetName,
            'jumlah_keluarga' => $this->faker->randomDigit,
            'status_kependudukan' => $this->faker->boolean,
            'nomor_hp' => $this->faker->phoneNumber,
            'user_id' => 1
        ];
    }
}
