<?php

namespace Bug\DoctrineListenerBundle\EventListener;

use Bug\DoctrineListenerBundle\Entity\Item;
use Bug\DoctrineListenerBundle\Entity\Shelve;
use Bug\DoctrineListenerBundle\Service\MapService;
use Bug\DoctrineListenerBundle\Service\OtherService;
use Doctrine\ORM\Event\LifecycleEventArgs;

class LifecycleEventListener
{
    /**
     * @var \Bug\DoctrineListenerBundle\Service\OtherService
     */
    protected $ms;

    public function __construct(MapService $ms)
    {
        $this->ms = $ms;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Item) {
            $em = $args->getEntityManager();
            $shelve = $em
                ->getRepository('DoctrineListenerBundle:Shelve')
                ->findBy(array('number' => $entity->getShelveNumber()));
            if (!$shelve) {
                $shelve = new Shelve();
                $shelve->setNumber($entity->getShelveNumber());
                $em->persist($shelve);
                $em->flush();
            }
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Item) {
            $em = $args->getEntityManager();
            $shelve = $em
                ->getRepository('DoctrineListenerBundle:Shelve')
                ->findBy(array('number' => $entity->getShelveNumber()));
            if (!$shelve) {
                $shelve = new Shelve();
                $shelve->setNumber($entity->getShelveNumber());
                $em->persist($shelve);
                $em->flush();
            }
        }
    }
}
