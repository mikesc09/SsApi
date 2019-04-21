<?php

use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_usuario = DB::table('usuarios')->first();
        if(!$super_usuario){
            DB::table('usuarios')->insert([[
                'email' =>  'alx@email.com',
                'password' => Hash::make('12345'),
                'activo' => 1,
                'salud_id' => '3685214970',
                'nombre' => 'Alejandro',
                'apellido_paterno' => 'Gosain',
                'apellido_materno' => 'Díaz',
                'su' => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ]]);
        }
    }
}
