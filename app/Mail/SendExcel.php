<?php

namespace App\Mail;

use App\Exports\ExcelExport;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Excel;

//use Illuminate\Contracts\Queue\ShouldQueue;

class SendExcel extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public $recipient,
        public ExcelExport $export,
        public $fileName,
        public $subject,
        public $year = null,
        public $month = null
    )
    {
        $this->to[] = [
            'address'   => $this->recipient,
            'name'      => $this->recipient,
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {
            return $this
                ->from(config('port.main.mail.sender.address'), config('port.main.mail.sender.name'))
                ->attachData($this->export->raw(Excel::XLS), $this->fileName)
                ->subject($this->subject)
                ->markdown(
                    'email.excel', [
                        'data' => $this->export
                    ]
                );
        } catch(Exception $e) {
            throw $e;
        }
    }
}
