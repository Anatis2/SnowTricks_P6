<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PictureFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $pictures = [
        	[	"trickName" => "Indy",
        		"filename" => "indy1.png"
			],
			[	"trickName" => "Mute",
				"filename" => "mute1.png"
			],
			[	"trickName" => "Mute",
				"filename" => "mute2.png"
			],
			[	"trickName" => "180",
				"filename" => "180_1.png"
			]
		];

        foreach($pictures as $k => $v) {
        	$picture = new Picture();

        	$trick = $manager->getRepository(Trick::class)->findOneBy(["name" => $v['trickName']]);

        	$picture
					->setTrick($trick)
					->setFilename($v['filename']);

        	$manager->persist($picture);
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
