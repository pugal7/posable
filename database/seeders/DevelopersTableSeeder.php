<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DevelopersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('developers')->where('email', 'pugal.karthy@gmail.com')->delete();

        DB::table('developers')->insert([
            'first_name' => 'pugal',
            'last_name' => 'karthy',
            'email' => 'pugal.karthy@gmail.com',
            'phone_number' => '0166779457',
            'address' => 'damansara perdana',
            
        ]);
    }
}
