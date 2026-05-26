<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define modules
        $modules = [
            'banner',
            'capacitacion',
            'contacto',
            'doc-apoyo',
            'doc-copladep',
            'doc-metodologico',
            'doc-sesion',
            'doc-subcomite',
            'documento-insumo-ped',
            'herramienta',
            'marco-juridico',
            'plan-estatal',
            'plan-municipal',
            'programa-derivado',
            'programa-estatales',
            'subcomite',
            'usuario',
            'rol',
            'registro-capacitacion'
        ];

        $permissions = [];

        foreach ($modules as $module) {
            $actions = ['ver', 'crear', 'editar', 'borrar'];
            
            // Adjust actions for specific modules if needed
            if ($module === 'contacto') {
                $actions = ['ver', 'borrar'];
            }

            foreach ($actions as $action) {
                $permissionName = "{$action}-{$module}";
                Permission::firstOrCreate(['name' => $permissionName]);
                $permissions[] = $permissionName;
            }
        }

        // Create Roles and Assign Permissions
        
        // Super Admin: Bypasses checks via AuthServiceProvider gate, but we'll give it all anyway
        $roleSuperAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $roleSuperAdmin->syncPermissions(Permission::all());

        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleAdmin->syncPermissions(Permission::all());

        $roleEditor = Role::firstOrCreate(['name' => 'editor']);
        $editorPermissions = Permission::where('name', 'like', 'ver-%')
            ->orWhere('name', 'like', 'crear-%')
            ->orWhere('name', 'like', 'editar-%')
            ->get();
        $roleEditor->syncPermissions($editorPermissions);

        $roleConsultor = Role::firstOrCreate(['name' => 'consultor']);
        $consultorPermissions = Permission::where('name', 'like', 'ver-%')->get();
        $roleConsultor->syncPermissions($consultorPermissions);

        // Assign super-admin role to existing validador users or specific user
        $adminUser = User::where('email', 'nery_p@hotmail.com')->first();
        if ($adminUser) {
            $adminUser->assignRole('super-admin');
        }
        
        // Also assign super-admin to any user with validador = 1 for safety during transition
        User::where('validador', 1)->each(function($user) {
            $user->assignRole('super-admin');
        });
    }
}
