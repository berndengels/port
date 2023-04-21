<?php

namespace App\Mail;

use App\Models\BoatDates;
use App\Models\ConfigSetting;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

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
        $this->mailer   = config('mail.mailer');
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
        $fileName = Carbon::today()->format('Ymd').'_'.Str::slug(config('app.name')) . '_rechnung.pdf';

        if($attache) {
            $this->attachData($attache, $fileName);
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
        return $this
            ->mailer($this->mailer)
            ->markdown('markdown/boat-permanent-invoice', [
                'data'      => $this->data,
                'customer'  => $this->customer,
                'settings'  => ConfigSetting::first(),
                'prices'    => $prices,
                'modus'     => config('port.main.boat.dates.modi')[$this->data->modus],
            ]);
    }
}
