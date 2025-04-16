<?php

namespace Database\Seeders;

use App\Enums\Role as RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            "create categories",
            "view categories",
            "edit categories",
            "delete categories",

            "create tasks",
            "view tasks",
            "edit tasks",
            "delete tasks"
        ];

        foreach ($permissions as $permission) {
            Permission::query()
                ->firstOrCreate(["name" => $permission]);
        }

        foreach (RoleEnum::cases() as $role) {
            Role::query()
                ->firstOrCreate(["name" => $role]);
        }

        $adminRole = Role::query()
            ->where('name', RoleEnum::ADMIN->value)
            ->first();
        if ($adminRole) {
            $adminRole->syncPermissions($permissions);
        }

        $moderatorRole = Role::query()
            ->where('name', RoleEnum::MODERATOR->value)
            ->first();
        if ($moderatorRole) {
            $moderatorRole->syncPermissions([
                "view tasks", "edit tasks", "delete tasks"
            ]);
        }

        $userRole = Role::query()
            ->where('name', RoleEnum::USER->value)
            ->first();
        if ($userRole) {
            $userRole->syncPermissions(["view tasks", "edit tasks"]);
        }
    }
}
