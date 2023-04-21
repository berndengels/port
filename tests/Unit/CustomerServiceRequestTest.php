<?php

namespace Tests\Unit;

use App\Events\ServiceRequested;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Notifications\NewServiceRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CustomerServiceRequestTest extends TestCase
{
    private $params = [
        'boat_id'       => null,
        'description'   => 'Test Service Request',
        'done_until'    => null,
        'services'      => [],
    ];

    private function getParams() {
        $this->params['boat_id']    = $this->customer->boats->first()->id;
        $this->params['done_until'] = Carbon::today()->addMonths(4)->format('Y-m-d');
        $this->params['services']   = Service::factory()->count(2)->create();

        return $this->params;
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_service_request()
    {
        $this
            ->asFakeCustomer()
            ->post(route('customer.serviceRequests.store', $this->getParams()), $this->getParams())
            ->assertOk()
        ;
    }

    public function test_service_request_event() {
        Event::fake([ServiceRequested::class]);
        ServiceRequest::factory()
            ->for($this->customer->boats->first(), 'boat')
            ->has(Service::factory()->count(3),'services')
            ->create()
        ;
        Event::assertDispatched(ServiceRequested::class);
    }

    public function test_service_request_send_mail() {
        Notification::fake();
        $user = $this->user;

        ServiceRequest::factory()
            ->for($this->customer->boats->first(), 'boat')
            ->has(Service::factory()->count(3),'services')
            ->create()
        ;
        Notification::assertSentTo(
            [$user], NewServiceRequest::class
        );
    }
}
