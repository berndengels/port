<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\AdminUser;
use Database\Seeders\Ext\MainTestSeeder;

class AdminUserSeeder extends MainTestSeeder
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
        /**
         * @var $user AdminUser
         */
        Role::getModel()->refresh();
        $user = AdminUser::factory()->create();
        if(Role::whereName('admin')->first()) {
            $user->assignRole('admin');
        }
    }
}
