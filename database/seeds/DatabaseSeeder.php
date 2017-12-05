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
        $this->call(TStateTableSeeder::class);
        $this->call(TStateNameTableSeeder::class); //(Remover)
        $this->call(PropUnitTypeTableSeeder::class);
        $this->call(PropUnitTypeNameTableSeeder::class); //(Remover)
        $this->call(ProcessTypeTableSeeder::class);
        $this->call(ProcessTypeNameTableSeeder::class); //(Remover)
        $this->call(CustomFormTableSeeder::class);
        $this->call(CustomFormNameTableSeeder::class); //(Remover)
        $this->call(RoleTableSeeder::class);
        $this->call(RoleNameTableSeeder::class); //(Remover)
        $this->call(ActorTableSeeder::class);
        $this->call(ActorNameTableSeeder::class); //(Remover)
        $this->call(RoleHasActorTableSeeder::class);
        $this->call(RoleHasUserTableSeeder::class);
        $this->call(ProcessTableSeeder::class);
        $this->call(ProcessNameTableSeeder::class); //(Remover)

        $this->call(TransactionTypeTableSeeder::class);
        $this->call(TransactionTypeNameTableSeeder::class); // (Remover)

        $this->call(EntTypeTableSeeder::class);
        $this->call(EntTypeNameTableSeeder::class); // (Remover)

        //$this->call(TransactionTableSeeder::class);
        //$this->call(TransactionStateTableSeeder::class);
        //$this->call(TransactionAckTableSeeder::class);

        //$this->call(EntityTableSeeder::class);
        //$this->call(EntityNameTableSeeder::class); //(Remover)

        //$this->call(RelTypeTableSeeder::class);
        //$this->call(RelTypeNameTableSeeder::class); // (Remover)
        
        //$this->call(RelationTableSeeder::class);
        //$this->call(RelationNameTableSeeder::class); //(Remover)

        $this->call(ActorIniciatesTTableSeeder::class); 
        
        $this->call(PropertyTableSeeder::class);
        $this->call(PropertyNameTableSeeder::class); //(Remover)

        //$this->call(ValueTableSeeder::class);

        //$this->call(ValueNameTableSeeder::class); //(Remover)

        $this->call(PropAllowedValueTableSeeder::class);
        $this->call(PropAllowedValueNameTableSeeder::class); //(Remover)
        $this->call(OperatorTableSeeder::class);
        /*
        $this->call(CustomFormHasPropTableSeeder::class); (Verificar se a tabela existe ainda, parece que foi alterado para o customFormHasEntType)
        */
        $this->call(CausalLinkTableSeeder::class);
        $this->call(WaitingLinkTableSeeder::class);
    }
}
