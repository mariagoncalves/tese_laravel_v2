<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguageTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ActorTableSeeder::class);
        $this->call(RoleTableSeeder::class);
    }
}
