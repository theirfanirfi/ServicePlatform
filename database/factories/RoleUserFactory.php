<?php

use Faker\Generator as Faker;

	static $num = 1;

$factory->define(App\UserRoles::class, function (Faker $faker) {
	static $num = 1;

	return [
        'roles_id' => rand(3,4),
	    'user_id' => $num++,
    ];
});
