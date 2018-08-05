<?php

use Faker\Generator as Faker;

$factory->define(App\Ship::class, function (Faker $faker) {
    return [
        'user_id' => rand(1,15),
	    'imo' => $faker->userName,
	    'name' => $faker->name,
	    'mmsi' => $faker->tld,
	    'vessel' => 'Bulk Carrier',
	    'gross_tonnage' => rand(1, 100),
	    'build' => $faker->year,
	    'flag' => $faker->country,
	    'home_port' => $faker->city
    ];
});
