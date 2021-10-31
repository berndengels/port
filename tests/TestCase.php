<?php
namespace Tests;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase, DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
//        $this->runDatabaseMigrations();
//        $this->refreshInMemoryDatabase();
        $this->refreshTestDatabase();
    }


    public function loginAsFakeUser()
    {
        $user = new AdminUser([
            'id'        => 1,
            'name'      => 'Otto Test Admin',
//            'email'     => 'otto@test.com',
//            'password'  => Hash::make('password')
        ]);
        $this->be($user);
        return $this;
    }
}
