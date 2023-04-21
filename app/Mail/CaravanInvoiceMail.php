<?php

namespace App\Mail;

use Carbon\Carbon;
use App\Models\CaravanDates;
use App\Models\ConfigSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class CaravanInvoiceMail extends Mailable
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
    public function __construct(CaravanDates $caravanDate, $attache = null)
    {
        $user = auth('admin')->user();
        $this->mailer   = config('mail.mailer');
        $this->data     = $caravanDate;
        $this->to[] = [
            'name'      => $caravanDate->caravan->carnumber,
            'address'   => $caravanDate->caravan->email,
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
            ->markdown('markdown/caravan-invoice', [
                'data'      => $this->data,
                'settings'  => ConfigSetting::first(),
                'prices'    => $prices,
            ]);
    }
}
