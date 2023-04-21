<?php

namespace App\Mail;

use App\Models\AdminUser;
use App\Models\ConfigSetting;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(protected Customer $customer)
    {
        $this->mailer = config('mail.mailer');
        // $users = AdminUser::permission('confirm Registration')->get();
        $users = app()->environment(['local'])
            ? AdminUser::whereEmail('engels@f50.de')->get()
            : AdminUser::permission('confirm Registration')->get();

        foreach ($users as $user) {
            $this->to[] = [
                'name'      => $user->name,
                'address'   => $user->email,
            ];
        }
        $this->from[] = [
            'name'      => $customer->name,
            'address'   => $customer->email,
        ];
        $this->subject("Bitte bestätige Registrierung von $customer->name ($customer->email)");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->mailer($this->mailer)
            ->markdown(
            'markdown.register', [
                'customer' => $this->customer,
                'settings'  => ConfigSetting::first(),
            ]
        );
    }
}
