<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SetPermissionsAndRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'insert all of basic permissions and roles';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $permissions = [
            ['name' => 'show_dashboard' , 'guard_name'=> 'web'],
            ['name' => 'show_orders', 'guard_name'=> 'web'],
            ['name' => 'edit_orders', 'guard_name'=> 'web'],
            ['name' => 'delete_orders', 'guard_name'=> 'web'],
            ['name' => 'show_chats', 'guard_name'=> 'web'],
            ['name' => 'edit_chats', 'guard_name'=> 'web'],
            ['name' => 'show_products', 'guard_name'=> 'web'],
            ['name' => 'edit_products', 'guard_name'=> 'web'],
            ['name' => 'delete_products', 'guard_name'=> 'web'],
            ['name' => 'show_tickets', 'guard_name'=> 'web'],
            ['name' => 'edit_tickets', 'guard_name'=> 'web'],
            ['name' => 'delete_tickets', 'guard_name'=> 'web'],
            ['name' => 'show_notifications', 'guard_name'=> 'web'],
            ['name' => 'edit_notifications', 'guard_name'=> 'web'],
            ['name' => 'delete_notifications', 'guard_name'=> 'web'],
            ['name' => 'show_comments', 'guard_name'=> 'web'],
            ['name' => 'edit_comments', 'guard_name'=> 'web'],
            ['name' => 'delete_comments', 'guard_name'=> 'web'],
            ['name' => 'show_users', 'guard_name'=> 'web'],
            ['name' => 'edit_users', 'guard_name'=> 'web'],
            ['name' => 'delete_users', 'guard_name'=> 'web'],
            ['name' => 'show_sends', 'guard_name'=> 'web'],
            ['name' => 'edit_sends', 'guard_name'=> 'web'],
            ['name' => 'delete_sends', 'guard_name'=> 'web'],
            ['name' => 'show_reductions', 'guard_name'=> 'web'],
            ['name' => 'edit_reductions', 'guard_name'=> 'web'],
            ['name' => 'delete_reductions', 'guard_name'=> 'web'],
            ['name' => 'show_categories', 'guard_name'=> 'web'],
            ['name' => 'edit_categories', 'guard_name'=> 'web'],
            ['name' => 'delete_categories', 'guard_name'=> 'web'],
            ['name' => 'show_addresses', 'guard_name'=> 'web'],
            ['name' => 'edit_addresses', 'guard_name'=> 'web'],
            ['name' => 'delete_addresses', 'guard_name'=> 'web'],
            ['name' => 'show_articles', 'guard_name'=> 'web'],
            ['name' => 'edit_articles', 'guard_name'=> 'web'],
            ['name' => 'delete_articles', 'guard_name'=> 'web'],
            ['name' => 'show_payments', 'guard_name'=> 'web'],
            ['name' => 'delete_payments', 'guard_name'=> 'web'],
            ['name' => 'edit_tasks', 'guard_name'=> 'web'],
            ['name' => 'delete_tasks', 'guard_name'=> 'web'],
            ['name' => 'show_tasks', 'guard_name'=> 'web'],
            ['name' => 'show_roles', 'guard_name'=> 'web'],
            ['name' => 'edit_roles', 'guard_name'=> 'web'],
            ['name' => 'delete_roles', 'guard_name'=> 'web'],
            ['name' => 'show_settings', 'guard_name'=> 'web'],
            ['name' => 'show_settings_base', 'guard_name'=> 'web'],
            ['name' => 'edit_settings_base', 'guard_name'=> 'web'],
            ['name' => 'show_settings_home', 'guard_name'=> 'web'],
            ['name' => 'edit_settings_home', 'guard_name'=> 'web'],
            ['name' => 'show_settings_aboutUs', 'guard_name'=> 'web'],
            ['name' => 'edit_settings_aboutUs', 'guard_name'=> 'web'],
            ['name' => 'show_settings_contactUs', 'guard_name'=> 'web'],
            ['name' => 'edit_settings_contactUs', 'guard_name'=> 'web'],
            ['name' => 'show_settings_fag', 'guard_name'=> 'web'],
            ['name' => 'edit_settings_fag', 'guard_name'=> 'web'],
        ];
        try {
            DB::beginTransaction();
            Permission::query()->insert($permissions);
            $admin = Role::create(['name' => 'admin']);
            $super_admin = Role::create(['name' => 'super_admin']);
            $administrator = Role::create(['name' => 'administrator']);
            $super_admin->syncPermissions(Permission::all());
            $administrator->syncPermissions(Permission::all());
            $user = User::create([
                'name'=> 'admin',
                'user_name' => 'admin',
                'phone' => '09336332901',
                'status' => User::CONFIRMED,
                'password' => 'admin',
                'ip' => 1,
            ]);
            $user->syncRoles([$admin,$super_admin,$administrator]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
        }
        return 0;
    }
}
