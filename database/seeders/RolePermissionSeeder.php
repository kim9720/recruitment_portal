<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar; 

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'view-jobs',
            'create-profile',
            'submit-application',
            'update-profile',
            'create-job',
            'edit-job',
            'view-applications',
            'schedule-interview',
            'message-candidate',
            'manage-users',
            'delete-content',
            'view-analytics',
            'provide-feedback',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $candidateRole = Role::create(['name' => 'candidate']);
        $candidateRole->givePermissionTo(['view-jobs', 'create-profile', 'submit-application', 'update-profile']);

        $recruiterRole = Role::create(['name' => 'hr']);
        $recruiterRole->givePermissionTo(['create-job', 'edit-job', 'view-applications', 'schedule-interview', 'message-candidate']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
        $adminRole->givePermissionTo(['manage-users', 'delete-content', 'view-analytics']);

        $hiringManagerRole = Role::create(['name' => 'hiring_manager']);
        $hiringManagerRole->givePermissionTo(['view-applications', 'provide-feedback', 'schedule-interview']);
    }
}
