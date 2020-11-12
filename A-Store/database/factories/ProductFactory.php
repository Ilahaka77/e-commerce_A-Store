<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'store_id' => 1,
        'kategori_id' => 1,
        'thumbnail' => $faker->image,
        'nm_barang' => $faker->name,
        'deskripsi' => $faker->text,
        'harga' => 5000,
        'stok' => 1
    ];
});
