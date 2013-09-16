<?php

namespace Bug\DoctrineListenerBundle\Fixtures;

use Bug\DoctrineListenerBundle\Entity\Item;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadData
    extends AbstractFixture
    implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 0;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // insert foo item
        $item_foo = new Item();
        $item_foo
            ->setName('foo')
            ->setShelveNumber(1);
        $manager->persist($item_foo);

        // insert bar item
        $item_bar = new Item();
        $item_bar
            ->setName('bar')
            ->setShelveNumber(1);
        $manager->persist($item_bar);

        // flush
        $manager->flush();
    }
}
