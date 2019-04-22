<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'project_name' => $faker->name,
        'project_status' => '1',
    ];
});
