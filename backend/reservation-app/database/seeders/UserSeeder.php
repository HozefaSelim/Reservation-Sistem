<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      // إنشــاء 10 مستخدمين عشوائيين لكل دور
      $roles = Role::all();

      foreach ($roles as $role) {
          User::factory()
              ->count(10)
              ->create([
                  'role_id' => $role->id
              ]);
      }
    }
}
