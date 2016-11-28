<?php

use App\Models\Business;
use Illuminate\Database\Seeder;

class BusinessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Business::truncate();

        Business::create([
           'name'        => 'Central Business',
           'description' => 'business description of central business',
            'business_id'     => 1
        ]);

        Business::create([
            'name'        => 'SubGroup Business 1',
            'description' => 'business description of subgroup business 1',
            'business_id'     => 1
        ]);

        Business::create([
            'name'        => 'SubGroup Business 2',
            'description' => 'business description of subgroup business 2',
            'business_id'     => 1
        ]);

        Business::create([
            'name'        => 'SubGroup Business 3',
            'description' => 'business description of subgroup business 3',
            'business_id'     => 1
        ]);
    }
}
