<?php

namespace Bug\DoctrineListenerBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MainMenu extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('HOME', array('route' => 'homepage'));
        $menu->addChild('ITEM', array('route' => 'item'));
        $menu->addChild('SHELVE', array('route' => 'shelve'));

        return $menu;
    }
}
