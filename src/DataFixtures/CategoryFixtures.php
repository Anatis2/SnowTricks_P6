<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = [
			"Grabs",
			"Rotations",
			"Flips",
			"Rotations désaxées",
			"Slides",
			"One foot tricks",
			"Old school"
        ];
        
        foreach($categories as $k => $v) {
            $category = new Category();
            $category->setName($v);
            $manager->persist($category);
        }
        
        $manager->flush();
    }
}
