<?php


$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'     => $faker->name,
        'username' => $faker->userName,
        'phone'    => $faker->phoneNumber,
        'address'  => $faker->address,
        'password' => bcrypt('password'),
        'type'     => 'regular',
        'active'   => 1,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Area::class, function(Faker\Generator $faker) {
   return [
     'name'        => $faker->city,
     'description' => $faker->sentence(12, true),
    'business_id'  => $faker->numberBetween(1, 4)
   ];
});

$factory->define(App\Models\Customer::class, function(Faker\Generator $faker){
    return [
      'name'     => $faker->name,
      'phone'    => $faker->phoneNumber,
      'address'  => $faker->address,
      'area_id'  => $faker->numberBetween(1, 15)
    ];
});