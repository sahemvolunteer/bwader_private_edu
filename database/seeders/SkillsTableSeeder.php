<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->delete();

        $this->createSkills();
    }

    protected function createSkills()
    {
        $types = ['AF', 'PS']; // Affective & Psychomotor Traits/Skills
        $d = [

            ['name' => 'الالتزام بالمواعيد', 'skill_type' => $types[0]],
            ['name' => 'النظافة', 'skill_type' => $types[0]],
            ['name' => 'الأمانة', 'skill_type' => $types[0]],
            ['name' => 'الاعتماد على النفس', 'skill_type' => $types[0]],
            ['name' => 'العلاقة مع الآخرين', 'skill_type' => $types[0]],
            ['name' => 'حسن الأدب', 'skill_type' => $types[0]],
            ['name' => 'سرعة الانتباه', 'skill_type' => $types[0]],
            ['name' => 'الخط اليدوي', 'skill_type' => $types[1]],
            ['name' => 'الألعاب والرياضة', 'skill_type' => $types[1]],
            ['name' => 'الرسم والفنون', 'skill_type' => $types[1]],
            ['name' => 'التلوين', 'skill_type' => $types[1]],
            ['name' => 'الأشغال اليدوية', 'skill_type' => $types[1]],
            ['name' => 'المهارات الموسيقية', 'skill_type' => $types[1]],
            ['name' => 'المرونة البدنية', 'skill_type' => $types[1]],

        ];
        DB::table('skills')->insert($d);
    }

}
