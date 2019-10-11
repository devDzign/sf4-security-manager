<?php

namespace App\EventSubscriber;

use App\Entity\Article;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;


class ImageCacheSubscriber implements EventSubscriber
{

    /**
     * @var CacheManager
     */
    private $cacheManager;
    /**
     * @var UploaderHelper
     */
    private $uploaderHelper;

    /**
     * ImageCacheSubscriber constructor.
     *
     * @param CacheManager   $cacheManager
     * @param UploaderHelper $uploaderHelper
     */
    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager   = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    /**
     * @return array|string[]
     */
    public function getSubscribedEvents()
    {
        return [
            Events::preRemove,
            Events::preUpdate,
        ];
    }


    /**
     * @param PreFlushEventArgs $event
     */
    public function preRemove(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if ( $entity instanceof Article ) {
            return;
        }


        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }

    /**
     * @param PreUpdateEventArgs $event
     */
    public function preUpdate(PreUpdateEventArgs $event)
    {
        $entity = $event->getEntity();

        if ( $entity instanceof Article ) {
            return;
        }

        /**
         * @var Article $entity
         */
        if ( $entity->getImageFile() instanceof UploadedFile ) {
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        }
    }


    /**
     * @param $entity
     */
    private function support($entity)
    {


    }


}
