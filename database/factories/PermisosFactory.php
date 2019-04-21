<?php

use Faker\Generator as Faker;
use App\Models\Sistema\Permiso;
use Carbon\Carbon;

$factory->define(Permiso::class, function (Faker $faker) {
    return [
        //
        'id' => str_random(32),
        'descripcion' => $faker->text($maxNbChars = 50),
        'grupo' => $faker->word,
        'su' => 1,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
