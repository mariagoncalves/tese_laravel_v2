<?php

use Illuminate\Database\Seeder;
use App\ProcessName;

class ProcessNameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Fazendo seeds ao modo antigo
        $dados = [
        	[
        		'process_id'  => '1',
        		'language_id' => '1',
        		'name'        => 'Processo gestão de concursos',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	]
        ];

        foreach ($dados as $value) {
            ProcessName::create($value);
        }
    }
}
