<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //insertar en la tabla roles
        DB::table('roles')->insert([
            [
                'id' => '1',
                'nombre' => 'ADMIN',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '2',
                'nombre' => 'CAPTURISTA',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => '3',
                'nombre' => 'CONTADOR',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        //insertar tabla permiso rol
        DB::table('rol_usuario')->insert([
            [
                'rol_id' => 1,
                'usuario_id' => 1,
            ],
            [
                'rol_id' => 2,
                'usuario_id' => 1,
            ]
        ]);
        //insertar una tabla permiso_rol

        DB::table('permiso_rol')->insert([
            [
                'permiso_id' => '9Kfw8wmzys6kgmr4g3qX2Cdk8ak1QZEt',
                'rol_id' => 1,
            ],
            [
                'permiso_id' => 'F2jsNyKuJ1UighVbq4jAUOIJDuyZJN5b',
                'rol_id' => 2,
            ],
            [
                'permiso_id' => 'LtPe32Sz5eqnKEvfXPrmUw2sBeJpOfuD',
                'rol_id' => 3,
            ]
        ]);
    }
}
