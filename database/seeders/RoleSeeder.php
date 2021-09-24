<?php
namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();

        $roles = ['admin','master','boating','control','guest'];
        $stamp = Carbon::now()->format('Y-m-d H:i:s');
        $data = [];

        foreach($roles as $name) {
            $data = [
                'name'       => $name,
                'guard_name' => 'web',
                'created_at' => $stamp,
                'updated_at' => $stamp,
            ];
            Role::create($data);
        }
    }
}
