<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

	private $encoder;

	public function __construct(UserPasswordEncoderInterface $encoder)
	{
		$this->encoder = $encoder;
	}

    public function load(ObjectManager $manager)
    {

        $users = [
			[
                "surname" => "Admin",
                "firstname" => "Admin",
                "email" => "admin@admin.fr",
                "password" => "admin",
				"avatarFilename" => "Avatar2.png",
				"activated_token" => "1",
                "roles" => ["ROLE_ADMIN"],
            ],
            [
                "surname" => "User",
                "firstname" => "User",
                "email" => "user@user.fr",
                "password" => "user",
				"avatarFilename" => "Avatar1.png",
				"activated_token" => "1",
                "roles" => []
            ],
			[
				"surname" => "User2",
				"firstname" => "User2",
				"email" => "user2@user2.fr",
				"password" => "user2",
				"avatarFilename" => "Avatar3.png",
				"activated_token" => "1",
				"roles" => []
			],
        ];
        
        foreach($users as $k => $v) {
            $user = new User();

			$pwdHash = $this->encoder->encodePassword($user, $v['password']);

            $user->setSurname($v['surname'])
                 ->setFirstname($v['firstname'])
                 ->setEmail($v['email'])
                 ->setPassword($pwdHash)
				 ->setRoles($v['roles'])
				 ->setAvatarFilename($v['avatarFilename'])
				 ->setActivatedToken($v['activated_token'])
            ;

            $manager->persist($user);
        }
        
        $manager->flush();

    }
}
