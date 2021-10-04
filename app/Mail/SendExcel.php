<?php

namespace App\Mail;

use App\Exports\CaravanDatesExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendExcel extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    protected $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($to, CaravanDatesExport $export, $file)
    {
        $this->to[] = [
            'address'   => $to,
            'name'      => $to,
        ];
        $this->data = $export;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
//            ->to($this->to)
            ->from(config('port.main.mail.sender.address'), config('port.main.mail.sender.name'))
            ->attach($this->file)
            ->subject("Caravan Rezeptions Daten")
            ->markdown('email.excel', [
                'data' => $this->data
            ])
       ;
    }
}
