<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 03.01.16
 * Time: 13:37
 */

namespace Syagr\PageBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Syagr\PageBundle\Entity\Page;

class LoadPageData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //$this->resetAutoincrement($manager, 'Syagr\PageBundle\Entity\Page');
        $page = new Page();
        $page->setId(1);
        $page->setTitle('Test page 1');
        $page->setText('Writing a basic fixture is simple. But what if you have multiple fixture classes and want to be able to refer to the data loaded in other fixture classes? For example, what if you load a User object in one fixture, and then want to refer to it in a different fixture in order to assign that user to a particular group?');
        $page->setStyle('style1');
        $page->setCustoms(
            [
                "text" => "text1",
                "arrays" => [
                    [
                        "p" => 5,
                        "c" => "fuu",
                    ],
                    [
                        "p" => 44,
                        "c" => "fuu2",
                    ]
                ]
            ]
        );


        $manager->persist($page);

        $page2 = new Page();
        $page2->setId(2);
        $page2->setTitle('Test page 2');
        $page2->setText('Writing a basic fixture is simple. But what if you have multiple fixture classes and want to be able to refer to the data loaded in other fixture classes? For example, what if you load a User object in one fixture, and then want to refer to it in a different fixture in order to assign that user to a particular group?');
        $page2->setStyle('style2');
        $page2->setCustoms(
            [
                "text" => "text1",
                "arrays" => [
                    [
                        "p" => 5,
                        "c" => "fuu",
                    ],
                    [
                        "p" => 44,
                        "c" => "fuu2",
                    ]
                ]
            ]
        );

        $manager->persist($page2);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }


}