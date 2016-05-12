<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 06.01.16
 * Time: 21:07
 */

namespace Syagr\AuthorizationRestApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Syagr\AuthorizationRestApiBundle\Entity\ApplicationToken;

class LoadAppTokens extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $token = new ApplicationToken();
        $token->setId(1);
        $token->setToken('app2121d3ds34gg33asgr23e23ce2asa');

        $manager->persist($token);

        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 3;
    }
}