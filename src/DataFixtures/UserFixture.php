<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends AppFixtures
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserFixture constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {

        $this->passwordEncoder = $passwordEncoder;
    }


    /**
     * @param ObjectManager $manager
     *
     * @return mixed|void
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(
            10,
            'main_users',
            function ($i) {

                $user = new User();
                $user->setEmail(sprintf('user%d@test.com', $i));
                $user->setFirstName($this->faker->firstName);
                $user->setPassword(
                    $this->passwordEncoder->encodePassword(
                        $user,
                        'admin'
                    )
                );

                return $user;
            }
        );

        $manager->flush();
    }
}
