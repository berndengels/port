<?php
namespace Tests\Unit;

use App\Models\AdminUser;
use App\Models\Caravan;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    /*
    public function test_admin_login() {
        $user = $this->user();
        $data = [
            'email' => $user->email,
            'password'  => $user->password,
        ];
        $response = $this->post('/admin/login', $data);
        $response
//            ->assertStatus(200)
            ->assertLocation('/admin/dashboard')
        ;
    }
    */
    public function test_admin_authenticated()
    {
        $caravan = Caravan::factory()->create();

        $this
            ->loginAsFakeUser()
            ->post('/admin/caravans/' . $caravan->id . '/replies', $caravan->toArray())
        ;
        $this->get('/admin/caravans')
            ->assertSee($caravan->carnumber)
        ;
    }
}
