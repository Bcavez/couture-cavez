<?php

namespace App\Subscriber;

use App\Entity\Product;
use App\Service\ImageService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProductImageSubscriber
 */
class ProductImageSubscriber implements EventSubscriberInterface
{
    /**
     * @var ImageService
     */
    private $imageService;

    /**
     * ProductImageSubscriber constructor.
     *
     * @param ImageService $imageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Callback when an image is uploaded before being persisted
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'easy_admin.pre_persist' => ['postPicture'],
        ];
    }

    /**
     * Take the uploaded image and save it to public folder with imageService
     * Then use the pathname returned by the service and save it to the object
     * so it is persisted into the DB
     *
     * @param GenericEvent $event
     */
    public function postPicture(GenericEvent $event)
    {
        $result = $event->getSubject();
        $method = $event->getArgument('request')->getMethod();

        if (!is_subclass_of($result, Product::class) || $method !== Request::METHOD_POST) {
            return;
        }

        /**
         * Psalm does not seem to detect that we already checked that result is indeed an instance of Product
         * 
         * @psalm-suppress PossiblyInvalidMethodCall
         */
        $file = $result->getPicture();

        if ($file instanceof UploadedFile) {
            $url = $this->imageService->saveToDisk($file);
            /**
             * Psalm does not seem to detect that we already checked that result is indeed an instance of Product
             *
             * @psalm-suppress PossiblyInvalidMethodCall
             */
            $result->setPicture($url);
        }
    }
}
