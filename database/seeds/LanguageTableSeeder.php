<?php

use Illuminate\Database\Seeder;
use App\Language;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $language_data = array(
            array('name' => 'Português','slug' => 'PT', 'state' => 'active'),
            array('name' => 'Inglês','slug' => 'EN', 'state' => 'active'),
        );

        //Inserir Utilizadores
        $language = Language::insert($language_data);
    }
}
