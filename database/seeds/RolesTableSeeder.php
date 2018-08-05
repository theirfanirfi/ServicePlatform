<?php

use Illuminate\Database\Seeder;
use App\Roles;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_superadmin = new Roles();
		$role_superadmin->name = 'superadmin';
		$role_superadmin->save();
		$role_admin = new Roles();
		$role_admin->name = 'admin';
		$role_admin->save();
		$role_editor = new Roles();
		$role_editor->name = 'buyer';
		$role_editor->save();
		$role_editor = new Roles();
		$role_editor->name = 'seller';
		$role_editor->save();		
    }
}
