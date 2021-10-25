<?php
namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\Role;
use Database\Seeders\Ext\MainSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AdminUserSeeder extends MainSeeder
{
    protected $table = 'admin_users';
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
        $user = AdminUser::factory()->create();
        $user->assignRole('admin');
    }
}
