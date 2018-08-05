<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Roles;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_superadmin = Roles::where('name', 'superadmin')->first();
		$superadmin = new User();
		$superadmin->name = 'Super Admin';
		$superadmin->email = 'admin@admin.com';
		$superadmin->password = bcrypt('123456');
		$superadmin->save();
		$superadmin->roles()->attach($role_superadmin);
    }
}
