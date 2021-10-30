<?php

namespace App\Mail;

use App\Models\AdminUser;
use App\Models\BoatDates;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Customer
     */
    protected $customer;
    /**
     * @var BoatDates
     */
    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BoatDates $boatDate, $attache = null)
    {
        $user = auth('admin')->user();
        $this->data     = $boatDate;
        $this->customer = $this->data->boat->customer;
        $this->to[] = [
            'name'      => $this->customer->name,
            'address'   => $this->customer->email,
        ];
        $this->from[] = [
            'name'      => $user->name,
            'address'   => $user->email,
        ];
        $appName = config('app.name');
        $this->subject("Rechnung von $appName");

        if($attache) {
            $this->attachData($attache, 'rechnung.pdf');
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $prices = json_decode($this->data->prices);

        if('permanent' === $this->customer->customer_type) {
            $view = 'boat-permanent-invoice';
        } else {
            $view = 'boat-guest-invoice';
        }
        return $this->markdown('markdown/' . $view, [
            'data'      => $this->data,
            'customer'  => $this->customer,
            'prices'    => $prices,
            'modus'     => config('port.main.boat.dates.modi')[$this->data->modus],
        ]);
    }
}
