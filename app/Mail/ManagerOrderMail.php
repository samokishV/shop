<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ManagerOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $content;

    /**
     * Create a new message instance.
     *
     * @param Order $user
     * @param array $content
     */
    public function __construct($user, $content)
    {
        $this->user = $user;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'New order';
        $link = config('app.url')."/admin/order/edit/".$this->user->id;

        return $this->subject($subject)->view('emails.order')
            ->with('user', $this->user)
            ->with('content', $this->content)
            ->with('link', $link);
    }
}
