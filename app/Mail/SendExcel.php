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

    public $to;
    public $data;
    public $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($to, CaravanDatesExport $export, $file)
    {
        $this->to = $to;
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
            ->markdown('email/excel')
            ->attach($this->file)
            ->from(config('port.email.from'))
            ->subject("Caravan Rezeptions Daten")
       ;
    }
}
