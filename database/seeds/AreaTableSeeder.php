<?php

use Illuminate\Database\Seeder;
use App\Models\Area;
class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::truncate();

        factory(Area::class, 15)->create();
    }
}
