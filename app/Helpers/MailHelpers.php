<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;


class MailHelpers
{
    public static function send($view, $params, $subject, $to, $name, $attachment = null)
    {
        Mail::send($view, $params, function ($email) use ($subject, $to, $name, $attachment) {
            $email->subject($subject);
            $email->to($to, $name);
            if ($attachment) {
                $email->attachData($attachment['data'], $attachment['name'], [
                    'mime' => $attachment['mime'],
                ]);
            }
        });
    }
}
