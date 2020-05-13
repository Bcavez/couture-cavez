<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class ImagesService
 */
class ImageService
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * ImagesService constructor.
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Take an uploaded file, change its name and move it to the public directory
     *
     * @param UploadedFile $image
     *
     * @return string
     */
    public function saveToDisk(uploadedFile $image)
    {
        $uploadDirectory = 'uploads/images';
        $path = $this->kernel->getProjectDir().'/public/'.$uploadDirectory;

        $imageName = uniqid().'.'.$image->guessExtension();

        $image->move($path, $imageName);

        return '/'.$uploadDirectory.'/'.$imageName;
    }
}