<?php

namespace App\Mail;

use App\Models\AdminUser;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Customer $customer)
    {
        //        $users = AdminUser::permission('confirm Registration')->get();
        $users = AdminUser::role('admin')->get();
        $this->customer = $customer;
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
        return $this->markdown(
            'markdown/register', [
            'customer'  => $this->customer,
            ]
        );
    }
}
