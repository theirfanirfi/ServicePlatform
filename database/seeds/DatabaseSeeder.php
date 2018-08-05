<?php

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
         $this->call([
         	 UsersTableSeeder::class,
	         RolesTableSeeder::class,
	         factory(App\User::class, 15)->create(),
	         factory(App\Ship::class, 15)->create(),
	         factory(App\UserRoles::class, 15)->create(),
	    ]);
    }
}
