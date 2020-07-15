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
        		"filename" => "indy1.png",
				"alt" => "Image d'Indy",
			],
			[	"trickName" => "Mute",
				"filename" => "mute1.png",
				"alt" => "Image de mute"
			],
			[	"trickName" => "Mute",
				"filename" => "mute2.png",
				"alt" => "Image de mute"
			],
			[	"trickName" => "Mute",
				"filename" => "mute3.png",
				"alt" => "Image de mute"
			],
			[	"trickName" => "Mute",
				"filename" => "mute4.png",
				"alt" => "Image de mute"
			],
			[	"trickName" => "180",
				"filename" => "180_1.png",
				"alt" => "Image de 180"
			],
			[	"trickName" => "Front flip",
				"filename" => "frontFlip1.png",
				"alt" => "Image de front flip"
			],
			[	"trickName" => "Nose slide",
				"filename" => "noseSlide.png",
				"alt" => "Image de nose slide"
			],
			[	"trickName" => "Backside Air",
				"filename" => "BacksideAir.png",
				"alt" => "Image de backside air"
			],
			[	"trickName" => "Method Air",
				"filename" => "MethodAir.png",
				"alt" => "Image de method air"
			],
		];

        foreach($pictures as $k => $v) {
        	$picture = new Picture();

        	$trick = $manager->getRepository(Trick::class)->findOneBy(["name" => $v['trickName']]);

        	$picture
					->setTrick($trick)
					->setFilename($v['filename'])
					->setAlt($v['alt']);

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
