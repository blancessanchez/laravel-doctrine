<?php

namespace App\EventSubscribers;

use App\Entities\District;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Illuminate\Support\Facades\Log;

class OnFlushEventSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return ['onFlush'];
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $entityManager = $args->getObjectManager();
        $unitOfWork = $entityManager->getUnitOfWork();

        foreach ($unitOfWork->getScheduledEntityInsertions() as $entity) {
            if ($entity instanceof District) {
                $entity->setName('New value inserted for district');
            }

            $unitOfWork->recomputeSingleEntityChangeSet(
                $entityManager->getClassMetadata(get_class($entity)),
                $entity
            );

            Log::info('Entity insertion changeset', [
                'entity' => get_class($entity),
                'changeSet' => $unitOfWork->getEntityChangeSet($entity)
            ]);
        }
    }
}