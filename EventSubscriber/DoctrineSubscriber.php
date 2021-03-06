<?php
/**
 * Created by PhpStorm.
 * User: Kronhyx
 * Date: 12/09/2018
 * Time: 1:33 PM
 */

namespace Kronhyx\TrackerBundle\EventSubscriber;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Kronhyx\TrackerBundle\Entity\Tracker;
use Kronhyx\TrackerBundle\Entity\TrackerTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class DoctrineSubscriber
 * @package Kronhyx\TrackerBundle\EventSubscriber
 * @author Randy Tellez Galán <kronhyx@gmail.com>
 */
class DoctrineSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist => Events::prePersist
        ];
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     * @throws \ReflectionException
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getEntity();
        $reflection = new \ReflectionClass($entity);
        $collection = new ArrayCollection($reflection->getTraitAliases());

        if ($collection->contains(TrackerTrait::class)) {
            /**@var Tracker $tracker */
            $tracker = new Tracker();
            $tracker->setCreatedAt(new \DateTime());
            $entity->setTracker($tracker);
        }

    }

}