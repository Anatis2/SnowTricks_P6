<?php

namespace App\EventListeners;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;


class UserRegistrationListener
{
	public function sendMail($email) {
		$transport = new GmailSmtpTransport('user', 'pass');
		$mailer = new Mailer($transport);
		$mailer->send($email);
	}

}