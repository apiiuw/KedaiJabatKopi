<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load('items.menu'); // Include related items and menu
    }

    public function build()
    {
        return $this->subject('Jabat Kopi Payment Receipt #' . $this->order->id_order)
                    ->view('emails.receipt');
    }
}
