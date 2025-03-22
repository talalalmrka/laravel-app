<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
          'name' => 'admin',
          'email' => 'talalminfo@gmail.com',
          'password'=> bcrypt('1234'),
        ]);
        User::factory(29)->create();
    }
}
