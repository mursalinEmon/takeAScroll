<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
$factory->define(Message::class, function (Faker $faker) {
    do{
        $from=rand(1,21);
        $to=rand(1,21);
    }while($from==$to);
    return [
        'from'=>$from,
        'to'=>$to,
        'body'=>$faker->sentence,
        'created_at'=>now()
    ];
});
