<?php

namespace App\EventListeners;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class UserRegistrationListener
{
	public function sendMail(MailerInterface $mailer) {
		$email = (new Email())
			->from('claire.coubard@gmail.com')
			->to('claire.coubard.test@gmail.com')
			->subject('Time for Symfony Mailer!')
			->text('Sending emails is fun again!')
			->html('<p>See Twig integration for better HTML integration!</p>');

		$mailer->send($email);
	}

}