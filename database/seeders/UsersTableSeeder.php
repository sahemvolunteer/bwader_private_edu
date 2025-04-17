<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Qs;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $this->createNewUsers();
        $this->createManyUsers(3);
    }

    protected function createNewUsers()
    {
        $password = Hash::make('123456'); // Password موحد

        $d = [

            [
                'name' => 'Najood',
                'email' => 'najood@gmail.com',
                'username' => 'najood',
                'password' => $password,
                'user_type' => 'super_admin',
                'code' => strtoupper(Str::random(10)),
                'remember_token' => Str::random(10),
            ],

            [
                'name' => 'Bushra',
                'email' => 'bushra@gmail.com',
                'username' => 'bushra',
                'password' => $password,
                'user_type' => 'teacher',
                'code' => strtoupper(Str::random(10)),
                'remember_token' => Str::random(10),
            ],

            [
                'name' => 'Kinda',
                'email' => 'kinda@gmail.com',
                'username' => 'kinda',
                'password' => $password,
                'user_type' => 'admin',
                'code' => strtoupper(Str::random(10)),
                'remember_token' => Str::random(10),
            ],

            [
                'name' => 'Loqman',
                'email' => 'loqman@gmail.com',
                'username' => 'loqman',
                'password' => $password,
                'user_type' => 'parent',
                'code' => strtoupper(Str::random(10)),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Accountant Ali',
                'email' => 'accountant@accountant.com',
                'user_type' => 'accountant',
                'username' => 'accountant',
                'password' => $password,
                'code' => strtoupper(Str::random(10)),
                'remember_token' => Str::random(10),
            ],

        ];

        DB::table('users')->insert($d);
    }

    protected function createManyUsers(int $count)
    {
        $data = [];
        $user_type = Qs::getAllUserTypes(['super_admin', 'librarian', 'student']);

        for ($i = 1; $i <= $count; $i++) {

            foreach ($user_type as $k => $ut) {

                $data[] = [
                    'name' => ucfirst($user_type[$k]) . ' ' . $i,
                    'email' => $user_type[$k] . $i . '@' . $user_type[$k] . '.com',
                    'user_type' => $user_type[$k],
                    'username' => $user_type[$k] . $i,
                    'password' => Hash::make($user_type[$k]),
                    'code' => strtoupper(Str::random(10)),
                    'remember_token' => Str::random(10),
                ];

            }

        }

        DB::table('users')->insert($data);
    }
}
