<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CustomerProfile;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
//    $num=rand(1,2);
//    $type=$num==1?"customer":"vendor";
    $type="customer";
    return [
        'name' => $faker->name,
        'contact_no'=>$faker->phoneNumber,
        'type'=>$type,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make("secret"), // password
        'remember_token' => Str::random(10),
    ];
});
$factory->afterCreating(User::class, function ($user, $faker) {
    CustomerProfile::create([
        'user_id'=>$user->id,
    ]);
});
