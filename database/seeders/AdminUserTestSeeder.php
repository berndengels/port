<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\AdminUser;
use Database\Seeders\Ext\MainTestSeeder;

class AdminUserTestSeeder extends MainTestSeeder
{
    protected $table = 'admin_users';
    protected $model = AdminUser::class;
    #
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::getModel()->refresh();
        /**
         * @var $user AdminUser
         */
        $user = AdminUser::factory()->connection('test')->create();
        Role::getModel()->refresh();

        if(Role::whereName('admin')->first()) {
            $user->assignRole('admin');
        }
    }
}
