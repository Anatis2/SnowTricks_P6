<?php

namespace App\Exception;

use Symfony\Component\Security\Core\Exception\AccountStatusException;

class AccountVerifyException extends AccountStatusException
{
	/**
	 * {@inheritdoc}
	 */
	public function getMessageKey()
	{
		return 'Veuillez activer votre compte en cliquant sur le lien qui vous a été envoyé par mail.';
	}
}