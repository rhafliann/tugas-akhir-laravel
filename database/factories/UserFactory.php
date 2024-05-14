<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_pegawai' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            '_password_' => 'password',
            'level' => 'staf',
            // 'kode_finger' => str_pad(fake()->randomNumber(5), 5, '0', STR_PAD_LEFT),
            'id_jabatan' => random_int(1, 3),
            'is_deleted' => '0',
        ];
    }
}
