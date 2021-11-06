<?php
namespace Tests\Unit;

use App\Models\AdminUser;
use App\Models\Caravan;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_admin_login()
    {
        $this
            ->post('/admin/logout')
            ->assertLocation('/')
        ;

        $this
            ->get('/admin')
            ->assertRedirect('/admin/login')
        ;

        $this
            ->asFakeUser()
            ->assertAuthenticated('admin')
            ->get('/admin')
            ->assertStatus(200)
        ;
    }

    public function test_customer_login()
    {
        $this
            ->post('/logout')
            ->assertLocation('/')
        ;
        $this
            ->get('/login')
            ->assertSeeText('Kunden Login')
        ;
        $this
            ->asFakeCustomer()
            ->assertAuthenticated('customer')
            ->get('/')
            ->assertStatus(302)
        ;
    }
}
