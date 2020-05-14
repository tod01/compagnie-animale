<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(InteractionsTableSeeder::class);
        #$this->call(AdsTableSeeder::class);
        #$this->call(UsersTableSeeder::class);
        #$this->call(AnimalsTableSeeder::class);
    }
}
