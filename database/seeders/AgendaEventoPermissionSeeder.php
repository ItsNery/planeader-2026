<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AgendaEventoPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = collect(['ver', 'crear', 'editar', 'borrar'])
            ->map(fn (string $action) => Permission::firstOrCreate([
                'name' => "{$action}-agenda-evento",
                'guard_name' => 'web',
            ]));

        foreach (['super-admin', 'admin'] as $roleName) {
            $role = Role::where('name', $roleName)->where('guard_name', 'web')->first();

            if ($role) {
                $role->givePermissionTo($permissions);
            }
        }

        $editor = Role::where('name', 'editor')->where('guard_name', 'web')->first();
        if ($editor) {
            $editor->givePermissionTo($permissions->reject(fn ($permission) => $permission->name === 'borrar-agenda-evento'));
        }

        $consultor = Role::where('name', 'consultor')->where('guard_name', 'web')->first();
        if ($consultor) {
            $consultor->givePermissionTo($permissions->firstWhere('name', 'ver-agenda-evento'));
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
