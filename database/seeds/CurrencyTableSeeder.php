<?php

use Illuminate\Database\Seeder;
use App\Currency;


class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     	Currency::create([
     		'code' => 'NGN',
     		'currency' => 'Nigerian Naira',
     		'rate' => '380.00',
            'base' => 1

     	]);

     	Currency::create([
     		'code' => 'USD',
     		'currency' => 'American Dollar',
     		'rate' => '1.40',

     	]);

     	// Currency::create([
     	// 	'code' => 'CAD',
     	// 	'currency' => 'Canadian Dollar',
     	// 	'rate' => '1.00',

     	// ]);
  
    }
}
