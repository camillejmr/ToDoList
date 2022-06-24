<?php

namespace App\Notification;


use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\User\UserInterface;

class Sender
{
    protected $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;

    }

    public function sendNewUserfNotification(UserInterface $user):void
    {
        $message=new Email();
        $message->from('mataeldigital@gmail.com')
        ->to('mataeldigital@gmail.com')
        ->subject('New account Created : '.$user->getEmail())
        ->html('New account created : <h3>'.$user->getEmail().'</h3>');

        $this->mailer->send($message,);
    }
}
