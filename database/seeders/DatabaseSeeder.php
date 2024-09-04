<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $email = 'admin@' . config('app.email_suffix');
    $firstUsr = User::whereEmail($email)->first();

    if (!$firstUsr) {
      User::factory()->create([
        'name' => 'Admin',
        'email' => $email,
        'password' => Hash::make('Password@123'),
      ]);
      $firstUsr = User::whereEmail($email)->first();
    }


    $role = app(Role::class)->findOrCreate('SUPERADMIN', 'web');
    $permission = app(Permission::class)->findOrCreate('GOD');
    $role->givePermissionTo($permission);

    $firstUsr->assignRole('SUPERADMIN');

    echo 'Admin user created';
  }
}
