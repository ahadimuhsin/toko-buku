<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		$list_roles = ["ADMIN", "CUSTOMER", "STAFF"];
        User::create([
            'name' => 'Muhsin Ahadi',
            'username' => 'muhsinahadi',
            'password' => Hash::make('password'),
            'email' => 'muhsin@mail.com',
            'roles' => json_encode($list_roles),
            'phone' => '089519705026',
            'status' => 'ACTIVE',
            'address' => 'Rawa Buaya, Indonesia'
        ]);

        $users = [];
        $faker = \Faker\Factory::create();


        for ($i=0; $i<10;$i++){
            $users[$i]= [
                'name' => $faker->name,
                'username' => $faker->userName,
                'password' => Hash::make('password'),
                'email' => $faker->unique()->safeEmail,
                'roles' => json_encode(["STAFF", "CUSTOMER"]),
                'status' => $faker->randomElement(['ACTIVE', 'NONACTIVE']),
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
            ];
        }
        DB::table('users')->insert($users);
    }
}
