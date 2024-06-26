<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::create([
            'name'=>'admin',
            'email'=>'admin@abc.com',
            'password' => Hash::make('kbtnetvn'),
        ]);
        $this->call([
            CctvSeeder::class,
            LicenseSeeder::class,
            PackSeeder::class,
        ]);
    }
}
