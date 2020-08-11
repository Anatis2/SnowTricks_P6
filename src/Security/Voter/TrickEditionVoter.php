<?php

namespace App\Security\Voter;

use App\Entity\Trick;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;

class TrickEditionVoter extends Voter
{
	private $security;

	public function __construct(Security $security)
	{
		$this->security = $security;
	}

	protected function supports($attribute, $subject)
	{
		return $attribute === 'EDIT'
			&& $subject instanceof App\Entity\Trick;
	}

	protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
	{
		// on retrouve l'utilisateur (on peut aussi ré-utiliser $this->security)
		$user = $token->getUser();

		// si l'utilisateur n'est pas authentifié, c'est non!
		if (!$user instanceof UserInterface) {
			return false;
		}

		// l'utilisateur est l'auteur de l'article
		if ($user === $subject->getUser()) {
			return true;
		}

		// l'utilisateur est un administrateur
		if ($this->security->isGranted('ROLE_USER')) {
			return true;
		}

		return false;
	}
}
