<?php

namespace App\DataFixtures;

use App\Entity\Message;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

		$messages = [
			[	"trickName" => "Indy",
				"content" => "Next !",
				"user" => "user2@user2.fr",
			],
			[	"trickName" => "Indy",
				"content" => "C'est bon je maîtrise cette figure !",
				"user" => "user2@user2.fr",
			],
			[	"trickName" => "Indy",
				"content" => "Si vous souhaitez un tuto en live, on pourrait s'organiser un aprem !",
				"user" => "user@user.fr",
			],
			[	"trickName" => "Indy",
				"content" => "Exemple de commentaire un peu plus long ........................................................................... 
							  Exemple de commentaire un peu plus long",
				"user" => "user2@user2.fr",
			],
			[	"trickName" => "Indy",
				"content" => "Merci d'avoir créé ce site, il est sympa !",
				"user" => "user2@user2.fr",
			],
			[	"trickName" => "Indy",
				"content" => "Content qu'elle vous plaise ! Elle est pas mal pour débuter, n'hésitez pas à regarder des vidéos pour vous entraîner ;-)",
				"user" => "admin@admin.fr",
			],
			[	"trickName" => "Indy",
				"content" => "Trop cool cette figure !",
				"user" => "user@user.fr",
			],
			[	"trickName" => "Mute",
				"content" => "Simple mais tellement grisante :-D",
				"user" => "user@user.fr",
			],
		];

		foreach($messages as $k => $v) {
			$message = new Message();
			$trick = $manager->getRepository(Trick::class)->findOneBy(["name" => $v['trickName']]);
			$user = $manager->getRepository(User::class)->findOneBy(["email" => $v['user']]);

			$message
				->setContent($v['content'])
				->setUser($user);

			$manager->persist($message);

			$message->setTrick($trick);

			$manager->persist($message);
		}

		$manager->flush();
    }

	public function getDependencies()
	{
		return array(
			TrickFixtures::class
		);
	}
}
