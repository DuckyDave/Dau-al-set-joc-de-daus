<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Database\Seeder;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // neteja els permissos desats en la caché
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // definim rols per als usuaris: player (jugador) i admin (administrador)
        Role::create(['guard_name' => 'api', 'name' => 'player']);
        Role::create(['guard_name' => 'api', 'name' => 'administrator']);
        // permisos per al rol de jugador
        Permission::create(['guard_name' => 'api', 'name' => 'update player nickname'])->assignRole('player');
        Permission::create(['guard_name' => 'api', 'name' => 'store game'])->assignRole('player');
        Permission::create(['guard_name' => 'api', 'name' => 'show all games'])->assignRole('player');
        Permission::create(['guard_name' => 'api', 'name' => 'delete all games'])->assignRole('player');
        // permisos per al rol d'administrador
        Permission::create(['guard_name' => 'api', 'name' => 'create player'])->assignRole('administrator');
        Permission::create(['guard_name' => 'api', 'name' => 'list players ranking'])->assignRole('administrator');
        Permission::create(['guard_name' => 'api', 'name' => 'show players ranking average'])->assignRole('administrator');
        Permission::create(['guard_name' => 'api', 'name' => 'show players ranking loser'])->assignRole('administrator');
        Permission::create(['guard_name' => 'api', 'name' => 'show players ranking winner'])->assignRole('administrator');

        // fake admininistrators
        $admin1 = User::create([
            'nick_name' => 'admin1',
            'email' => 'admin1@example.net',
            'password' => bcrypt('password'),
        ])->assignRole('administrator');

        $admin2 = User::create([
            'nick_name' => 'admin2',
            'email' => 'admin2@example.net',
            'password' => bcrypt('password'),
        ])->assignRole('administrator');

        // five fake players
       User::factory(5)->create()->each(function($user) {
           $user->assignRole('player');
       });
    }
}
