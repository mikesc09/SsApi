<?php

use Illuminate\Database\Seeder;
use App\Models\Sistema\Permiso;
use Carbon\Carbon;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // factory(Permiso::class)->times(5)->create();
        DB::table('permisos')->insert([
            [
                'id' => '9Kfw8wmzys6kgmr4g3qX2Cdk8ak1QZEt',
                'descripcion' => 'Asperiores tempora vel neque.',
                'grupo' => 'ingresos',
                'su' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'F2jsNyKuJ1UighVbq4jAUOIJDuyZJN5b',
                'descripcion' => 'Asperiores tempora vel neque.',
                'grupo' => 'contabilidad',
                'su' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'LtPe32Sz5eqnKEvfXPrmUw2sBeJpOfuD',
                'descripcion' => 'Asperiores tempora vel neque.',
                'grupo' => 'contabilidad',
                'su' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'y1b0PzMmCB9sGFigoq5ZG5J3twPgqHy1',
                'descripcion' => 'Asperiores tempora vel neque.',
                'grupo' => 'contabilidad',
                'su' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'yz4SGEgbOcUv7dDLWkNaS584VfvGPrT9',
                'descripcion' => 'Asperiores tempora vel neque.',
                'grupo' => 'ingresos',
                'su' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        //insertar tabla permiso usuario
        DB::table('permiso_usuario')->insert([
            [
                'permiso_id' => 'F2jsNyKuJ1UighVbq4jAUOIJDuyZJN5b',
                'usuario_id' => 1,
                'denegar' => 0
            ],
            [
                'permiso_id' => '9Kfw8wmzys6kgmr4g3qX2Cdk8ak1QZEt',
                'usuario_id' => 1,
                'denegar' => 1
            ]
        ]);

    }
}
