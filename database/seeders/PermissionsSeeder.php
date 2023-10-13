<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** Create roles section */
        $admin = Role::create(['name' => 'Admin']);
        $editor = Role::create(['name' => 'Editor']);
        $staff = Role::create(['name' => 'Staff']);
        $student = Role::create(['name' => 'Student']);

        /** Create permissions section */
        // Event permissions
        Permission::create(['name' => 'event-access']);
        Permission::create(['name' => 'event-create']);
        Permission::create(['name' => 'event-edit']);
        Permission::create(['name' => 'event-delete']);
        Permission::create(['name' => 'event-see-all']); // see all events, not just authored ones
        // Enrollment permissions
        Permission::create(['name' => 'enrollment-signup']); // permission to signup on an event date
        Permission::create(['name' => 'enrollment-sign-off']); // permission to sign off from an event date
        // Global blacklist permissions
        Permission::create(['name' => 'blacklist-access']); // access global blacklist section
        Permission::create(['name' => 'blacklist-edit']);
        Permission::create(['name' => 'blacklist-user-delete']);
        // Template permissions
        Permission::create(['name' => 'template-access']); // access template section in admin
        Permission::create(['name' => 'template-create']);
        Permission::create(['name' => 'template-edit']);
        Permission::create(['name' => 'template-delete']);
        Permission::create(['name' => 'template-see-all']); // see all templates, not just authored ones
        Permission::create(['name' => 'template-approve']); // approve templates

        Permission::create(['name' => 'admin-access']); // access and login to admin panel
        Permission::create(['name' => 'user-access']); // ability to assign role to a certain user (only for admin)

        $editor->syncPermissions([
            'event-access',
            'event-create',
            'event-edit',
            'event-delete',
            'blacklist-access',
            'blacklist-edit',
            'template-access',
            'template-create',
            'template-edit',
            'template-delete',
            'admin-access'
        ]);

        $staff->syncPermissions([
            'event-access',
            'enrollment-signup',
            'enrollment-sign-off',
            'admin-access'
        ]);

        $student->syncPermissions([
            'enrollment-signup',
            'enrollment-sign-off',
        ]);

        // Assign admin role to rebr00 and xvojs03
        DB::table('model_has_roles')->insert([
            'role_id' => Roles::ADMIN_ID,
            'model_type' => 'App\Models\User',
            'model_id' => 1
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => Roles::ADMIN_ID,
            'model_type' => 'App\Models\User',
            'model_id' => 2
        ]);
    }
}
