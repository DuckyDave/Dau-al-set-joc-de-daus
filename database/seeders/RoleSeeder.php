<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Database\Seeder;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // definim rols per als usuaris: player (jugador) i admin (administrador)
        $player = Role::create(['guard_name' => 'api', 'name' => 'player']);
        $admin = Role::create(['guard_name' => 'api', 'name' => 'admin']);
        
        // permisos per al rol de jugador
        Permission::create(['guard_name' => 'api', 'name' => 'update user nickname'])->assignRole($player);
        Permission::create(['guard_name' => 'api', 'name' => 'store game'])->assignRole($player);
        Permission::create(['guard_name' => 'api', 'name' => 'show games'])->assignRole($player);
        Permission::create(['guard_name' => 'api', 'name' => 'delete games'])->assignRole($player);
        // permisos per al rol d'administrador
        Permission::create(['guard_name' => 'api', 'name' => 'create player'])->assignRole($admin);
        Permission::create(['guard_name' => 'api', 'name' => 'list players ranking'])->assignRole($admin);
        Permission::create(['guard_name' => 'api', 'name' => 'show players ranking average'])->assignRole($admin);
        Permission::create(['guard_name' => 'api', 'name' => 'show players ranking loser'])->assignRole($admin);
        Permission::create(['guard_name' => 'api', 'name' => 'show players ranking winner'])->assignRole($admin);
    }
}
