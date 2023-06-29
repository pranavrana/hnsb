<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_settings')->insert([
            [
                'label' => "Admission Fees",
                'key' => 'admissionfees',
                'value' => '100',
                'is_default' => 1,
                'status' => 0
            ],
            [
                'label' => "Admission Cut Off Date",
                'key' => 'admissioncutoffdate',
                'value' => \Carbon\Carbon::now()->addDays(5)->format('d-m-Y'),
                'is_default' => 1,
                'status' => 0
            ],
            [
                'label' => "College Fees Cut Off Extention Date",
                'key' => 'collegefeescutoffextentiondate',
                'value' => \Carbon\Carbon::now()->addDays(10)->format('d-m-Y'),
                'is_default' => 1,
                'status' => 1
            ],
            [
                'label' => "College Fees Cut Off Date",
                'key' => 'collegefeescutoffdate',
                'value' => \Carbon\Carbon::now()->addDays(15)->format('d-m-Y'),
                'is_default' => 1,
                'status' => 0
            ]
        ]);
    }
}
