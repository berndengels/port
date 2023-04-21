<?php

namespace App\Listeners;

use App\Models\AccessLog;
use Illuminate\Auth\Events\Authenticated;
use Jenssegers\Agent\Agent;

class StoreAccessLog
{
    private $guard = 'admin';
    private $email = 'admin@test.loc';

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Authenticated $event)
    {
        if('testing' === app()->environment()) {
            return null;
        }
        $isTestUser = $this->guard === $event->guard && $this->email === $event->user->email;
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        if($ip !== '127.0.0.1' && $isTestUser) {
/*
            $data = geoip()->getLocation($ip)->toArray();
            $data['user_agent'] = (new Agent())->getUserAgent();
            AccessLog::create($data);
*/
        }
    }
}
