<?php

use Illuminate\Database\Seeder;
use App\Models\Blood;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BloodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bloods')->delete();
        $bloods = [
            [
                'name' => 'O-',
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now()
            ],
            [
                'name' => 'O+',
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now()
            ],
            [
                'name' =>'A+',
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now()
            ],
            [
                'name' => 'A-',
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now()
            ],
            [
                'name' => 'B+',
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now()
            ],
            [
                'name' =>'B-',
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now()
            ],
            [
                'name' =>'AB+',
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now()
            ],
            [
                'name' =>'AB-',
                'created_at' =>Carbon::now(),
                'updated_at' =>Carbon::now()
            ]
];
        DB::table('bloods')->insert($bloods);
    }
}
