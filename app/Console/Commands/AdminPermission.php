<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\AdminUser;
use Illuminate\Console\Command;

class AdminPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:set-admin-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the admin permission for the demo admin user';

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
		if($this->confirm('You really want change the user role to admin', true)) {
			$demoUser = AdminUser::with('roles')
				->role('demonstration')
				->first()
			;

			if($demoUser) {
				$demoUser->assignRole('admin');
			} else {
				AdminUser::with('roles')->first()->assignRole('admin');
			}

			$this->info("the new role is: admin");
		}
    }
}
