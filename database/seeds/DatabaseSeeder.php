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
        // $this->call(UsersTableSeeder::class);
        $this->truncatetable([
            'usuarios',
            'roles',
            'rol_usuario',
            'permisos',
            'permiso_rol',
        ]);
        //llamar al seeder que se creo
        $this->call([
            UsuariosSeeder::class,
            PermisosSeeder::class,
            RolesSeeder::class,
        ]);
    }

    protected function truncatetable(array $table)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        foreach ($table as $tabla) {
            # iterando...
            DB::table($tabla)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
