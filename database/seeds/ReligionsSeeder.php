<?php

use Illuminate\Database\Seeder;
use App\Models\Religion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReligionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('religions')->delete();

        $religions = [

            [
                'en'=> 'Muslim',
                'ar'=> 'مسلم'
            ],
            [
                'en'=> 'Christian',
                'ar'=> 'مسيحي'
            ],
            [
                'en'=> 'Other',
                'ar'=> 'غيرذلك'
            ]

        ];

        foreach ($religions as $religion){
            $rg = new Religion();
            $rg->name = $religion;
            $rg->created_at = Carbon::now();
            $rg->updated_at = Carbon::now();
            $rg->save();
        }
    }
}
