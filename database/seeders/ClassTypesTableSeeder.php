<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('class_types')->delete();
        $data = [
            ['name' => 'حضانة', 'code' => 'C'],
            ['name' => 'تمهيدي', 'code' => 'PN'],
            ['name' => 'روضة', 'code' => 'N'],
            ['name' => 'ابتدائي', 'code' => 'P'],
            ['name' => 'متوسط', 'code' => 'J'],
            ['name' => 'ثانوي', 'code' => 'S'],
        ];


        DB::table('class_types')->insert($data);

    }
}
