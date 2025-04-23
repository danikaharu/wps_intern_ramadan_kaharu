<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roleDirektur = Role::create(['name' => 'Direktur']);
        Role::create(['name' => 'Manager Operasional']);
        Role::create(['name' => 'Manager Keuangan']);
        Role::create(['name' => 'Staff']);

        foreach (config('permission.list_permissions') as $permission) {
            foreach ($permission['lists'] as $list) {
                Permission::create(['name' => $list]);
            }
        }

        $userDirektur = User::first();
        $userDirektur->assignRole('direktur');
        $roleDirektur->givePermissionTo(Permission::all());
    }
}
