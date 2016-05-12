<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 06.01.16
 * Time: 20:15
 */


namespace Syagr\AuthorizationRestApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Syagr\AuthorizationRestApiBundle\Security\TokenAuthenticator;


class LoadUsers extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //$this->resetAutoincrement($manager, 'Syagr\PageBundle\Entity\Page');
        $newUser1 = new User();
        $newUser1->setId(1);
        $newUser1->setUsername('user');
        $newUser1->setEnabled(true);
        $newUser1->setEmail('syagrovskiyandriy@gmail.com');
        $newUser1->setPlainPassword('user');
        $newUser1->addRole(TokenAuthenticator::ROLE_USER);

        $manager->persist($newUser1);

        $newUser2 = new User();
        $newUser2->setId(2);
        $newUser2->setUsername('admin');
        $newUser2->setEnabled(true);
        $newUser2->setEmail('syagrovskiyandriy1@gmail.com');
        $newUser2->setPlainPassword('admin');
        $newUser2->addRole(TokenAuthenticator::ROLE_ADMIN);

        $manager->persist($newUser2);

        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}