<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $title = $faker->sentence,
        'url' => Str::slug($title),
        'description' => $faker->paragraph,
    ];
});
