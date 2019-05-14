<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ManagerOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    private $content;

    /**
     * Create a new message instance.
     *
     * @param $content
     */
    public function __construct($content)
    {
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
        $link = config('app.url')."/admin/order/edit/".$this->content[0]->id;
        var_dump($link);
        return $this->subject($subject)->view('emails.order')
            ->with('content', $this->content)
            ->with('link', $link);
    }
}
