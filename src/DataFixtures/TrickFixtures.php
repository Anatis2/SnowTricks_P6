<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TrickFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
		$categoriesDatas = [
			"Grabs" =>
				[
					[ "name" => "Mute",
					  "description" => "Le mute fait partie de la catégorie des grabs, qui consistent à attraper la planche avec la main pendant le saut.
		  					Le verbe anglais to grab signifie « attraper. »
		  					Le mute se fait par une saisie de la carre frontside de la planche entre les deux pieds avec la main avant."
					],
					[ "name" => "Indy",
					  "description" => "Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière."
					],
					[ "name" => "test",
					  "description" => "test"
					],
					[ "name" => "ex 2 figures",
					  "description" => "ex 2 figures"
					],
					[ "name" => "figuretest",
					  "description" => "bidule"
					],
					[ "name" => "atre",
					  "description" => "a"
					],
					[ "name" => "dfdf",
					  "description" => "bidule"
					]
				],
			"Rotations" =>
				[
					[ "name" => "180",
						"description" => "Le 180 désigne un demi-tour, soit 180 degrés d'angle."
					],
					[ "name" => "360",
						"description" => "Trois six pour un tour complet."
					],
					[ "name" => "540",
						"description" => "Cinq quatre pour un tour et demi."
					],
					[ "name" => "720",
						"description" => "Sept deux pour deux tours complets."
					]
				],
			"Flips" =>
				[
					[ "name" => "Front flip",
					  "description" => "Un front flip correspond à une rotation avant.
		  					Il est possible de faire plusieurs flips à la suite, et d'ajouter un grab à la rotation.
		  					Les flips agrémentés d'une vrille existent aussi (Mac Twist, Hakon Flip, ...), mais de manière beaucoup plus rare, et se confondent souvent avec certaines rotations horizontales désaxées.
		  					Néanmoins, en dépit de la difficulté technique relative d\'une telle figure, le danger de retomber sur la tête ou la nuque est réel et conduit certaines stations de ski à interdire de telles figures dans ses snowparks."
					],
					[ "name" => "Test figure flip",
					  "description" => "flip"
					]
				],
			"Rotations désaxées" =>
				[
					[ "name" => "",
					  "description" => ""
					]
				],
			"Slides" =>
				[
					[ "name" => "Nose slide",
					  "description" => "On glisse avec l'avant de la planche sur la barre."
					]
				],
			"One foot tricks" =>
				[
					[ "name" => "",
					  "description" => ""
					]
				],
			"Old school" =>
				[
					[ "name" => "Backside Air",
					  "description" => "A compléter"
					],
					[ "name" => "Method Air",
					  "description" => "A compléter"
					]
				]
		];

		foreach($categoriesDatas as $key => $categoryDatas) {

			$category = new Category();
			$category->setName($key);

			$manager->persist($category);

			foreach($categoryDatas as $k => $v) {
				$trick = new Trick();
				$trick->setCategory($category)
					->setName($v['name'])
					->setDescription($v['description']);

				$manager->persist($trick);
			}
		}

        $manager->flush();
    }
}
