<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Trick;
use App\Repository\TrickRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
		$tricksDatas = 
			[
				[ "name" => "Mute",
					"description" => "Le mute fait partie de la catégorie des grabs, qui consistent à attraper la planche avec la main pendant le saut.
					Le verbe anglais to grab signifie « attraper. »
					Le mute se fait par une saisie de la carre frontside de la planche entre les deux pieds avec la main avant.",
					"category" => "Grabs",
					"user" => "admin@admin.fr"
				],
				[ "name" => "Indy",
					"description" => "Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière.",
					"category" => "Grabs",
					"user" => "admin@admin.fr"
				],
				[ "name" => "180",
					"description" => "Le 180 désigne un demi-tour, soit 180 degrés d'angle.",
					"category" => "Rotations",
					"user" => "admin@admin.fr"
				],
				[ "name" => "360",
					"description" => "Trois six pour un tour complet.",
					"category" => "Rotations",
					"user" => "admin@admin.fr"
				],
				[ "name" => "540",
					"description" => "Cinq quatre pour un tour et demi.",
					"category" => "Rotations",
					"user" => "admin@admin.fr"
				],
				[ "name" => "720",
					"description" => "Sept deux pour deux tours complets.",
					"category" => "Rotations",
					"user" => "admin@admin.fr"
				],
				[ "name" => "Front flip",
					"description" => "Un front flip correspond à une rotation avant.
					Il est possible de faire plusieurs flips à la suite, et d'ajouter un grab à la rotation.
					Les flips agrémentés d'une vrille existent aussi (Mac Twist, Hakon Flip, ...), mais de manière beaucoup plus rare, et se confondent souvent avec certaines rotations horizontales désaxées.
					Néanmoins, en dépit de la difficulté technique relative d\'une telle figure, le danger de retomber sur la tête ou la nuque est réel et conduit certaines stations de ski à interdire de telles figures dans ses snowparks.",
					"category" => "Flips",
					"user" => "admin@admin.fr"
				],
				[ "name" => "Nose slide",
					"description" => "On glisse avec l'avant de la planche sur la barre.",
					"category" => "Slides",
					"user" => "admin@admin.fr"
				],
				[ "name" => "Backside Air",
					"description" => "A compléter",
					"category" => "Old school",
					"user" => "admin@admin.fr"
				],
				[ "name" => "Method Air",
					"description" => "A compléter",
					"category" => "Old school",
					"user" => "admin@admin.fr"
				]
			];

		foreach($tricksDatas as $k => $v) {

				$trick = new Trick();
				$category = $manager->getRepository(Category::class)->findOneBy(["name" => $v['category']]);
				$user = $manager->getRepository(User::class)->findOneBy(["email" => $v['user']]);

				$trick
					->setName($v['name'])
					->setDescription($v['description'])
					->setCategory($category);

				$manager->persist($trick);

				$trick->setUser($user);

				$manager->persist($trick);
		}

        $manager->flush();
    }

	public function getDependencies()
	{
		return array(
			CategoryFixtures::class,
			UserFixtures::class
		);
	}
}
