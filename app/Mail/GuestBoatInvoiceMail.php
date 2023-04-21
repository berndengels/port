<?php

namespace App\Mail;

use Carbon\Carbon;
use App\Models\GuestBoatDates;
use App\Models\ConfigSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class GuestBoatInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var BoatDates
     */
    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(GuestBoatDates $guestBoatDate, $attache = null)
    {
        $user = auth('admin')->user();
        $this->mailer   = config('mail.mailer');
        $this->data     = $guestBoatDate;
        $this->to[] = [
            'name'      => $guestBoatDate->boat->name,
            'address'   => $guestBoatDate->boat->email,
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
            ->markdown('markdown/boat-guest-invoice', [
                'data'      => $this->data,
                'settings'  => ConfigSetting::first(),
                'prices'    => $prices,
                'modus'     => config('port.main.boat.dates.modi')[$this->data->modus],
            ]);
    }
}
