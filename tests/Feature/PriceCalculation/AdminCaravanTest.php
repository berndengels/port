<?php
namespace Tests\Feature\PriceCalculation;

use App\Models\AdminUser;
use App\Models\Caravan;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AdminCaravanTest extends TestCase
{
    /**
     * @var Caravan $caravan
     */
    protected $caravanParams;
    protected $permission = ['read Caravan', 'write Caravan', 'read CaravansMenu'];
    protected function setUp():void
    {
        parent::setUp();
        $this->caravanParams = Caravan::factory()->definition();
    }

    public function test_caravan_create()
    {
        $this
            ->asFakeUser($this->permission)
            ->post('/admin/caravans', $this->caravanParams)
            ->assertStatus(200)
            ->assertSeeText($this->caravanParams['carnumber'])
        ;
    }

    public function test_caravan_update()
    {
        $this->test_caravan_create();
        $caravan = Caravan::whereCarnumber($this->caravanParams['carnumber'])->first();
        $email = 'test.' . $caravan->email;
        $this->caravanParams['email'] = $email;

        $this
            ->followingRedirects()
            ->asFakeUser($this->permission)
            ->put('/admin/caravans/' . $caravan->id , $this->caravanParams)
            ->assertStatus(200)
            ->assertSeeText($email)
        ;
    }

    public function test_caravan_destroy()
    {
        $this->test_caravan_create();
        $caravan = Caravan::whereCarnumber($this->caravanParams['carnumber'])->first();

        $this
            ->followingRedirects()
            ->asFakeUser($this->permission)
            ->delete('/admin/caravans/' . $caravan->id)
            ->assertStatus(200)
            ->assertSeeText('success: Caravan '.$this->caravanParams['carnumber'].' erfolgreich gelöscht!')
        ;
    }
}
