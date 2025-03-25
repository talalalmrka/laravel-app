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
      'password' => bcrypt(1234),
    ])->each(function (User $user) {
      $user->assignRole('admin');
    });
    User::factory()->create([
      'name' => 'member',
      'email' => 'member@gmail.com',
      'password' => bcrypt(1234),
    ])->each(function (User $user) {
      $user->assignRole('member');
    });
    User::factory(28)->create();
  }
}
