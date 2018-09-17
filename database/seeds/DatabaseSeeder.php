<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $email = 'quan.dm@teko.vn';

        $roles = [
            'Admin', 'User'
        ];

        foreach ($roles as $role) {
            $countUser = Role::where('name', $role)->count();

            if ($countUser == 0) {
                Role::create([
                    'name' => $role,
                ]);
            }
        }

        $countUser = User::where('email', $email)->count();

        if ($countUser == 0) {
          $user = Sentinel::registerAndActivate([
                'name' => $email,
                'email' => $email,
                'password' => 'secret'
            ]);

            $role = Sentinel::findRoleByName('Admin');

            $role->users()->attach($user);

        }

    }
}
