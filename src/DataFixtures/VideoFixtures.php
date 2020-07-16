<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $videos = [
        	[
				"trickName" => "Indy",
				"url" => "https://www.youtube.com/embed/51sQRIK-TEI",
			],
			[
				"trickName" => "Mute",
				"url" => "https://www.youtube.com/embed/jm19nEvmZgM",
			]
		];

        foreach ($videos as $k => $v) {
        	$video = new Video();
			$trick = $manager->getRepository(Trick::class)->findOneBy(["name" => $v['trickName']]);

			$video
				->setUrl($v['url'])
				->setTrick($trick);

			$manager->persist($video);
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
