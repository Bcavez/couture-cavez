<?php

namespace App\DataFixtures;

use App\Entity\Cloth;
use App\Entity\Mask;
use App\Entity\Pants;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class ProductFixtures
 */
class ProductFixtures extends Fixture
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * ProductFixtures constructor.
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->faker = Factory::create();
    }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 4; ++$i) {
            // Cloth
            $product1 = new Cloth();
            $this->setCommonFields($product1);
            // Mask
            $product2 = new Mask();
            $this->setCommonFields($product2);
            // Pants
            $product3 = new Pants();
            $this->setCommonFields($product3);

            $manager->persist($product1);
            $manager->persist($product2);
            $manager->persist($product3);
        }

        $manager->flush();
    }

    /**
     * @param Product $entity
     *
     * @throws \Exception
     */
    private function setCommonFields(Product $entity)
    {
        $url = $this->uploadImageFromFixturesPath('fixture1.jpeg');
        $entity->setPicture($url);

        $entity->setName($this->faker->firstName);
        $entity->setPrice($this->faker->randomNumber(2));
        $entity->setDescription($this->faker->text(300));
        $entity->setSummary($this->faker->text(100));

        // Set published status randomly
        $coinToss = random_int(0, 1);
        if ($coinToss === 1) {
            $entity->setPublished(true);
        }
    }

    /**
     * @param $path
     *
     * @return string
     */
    private function uploadImageFromFixturesPath($path)
    {
        // We first need to copy the image to temp location
        // so it is that temp file which is moved around by the fakeUploadImage
        $fs = new Filesystem();
        $targetPath = sys_get_temp_dir().'/'.$path;
        $fs->copy(__DIR__.'/images/'.$path, $targetPath, true);

        // We pass a File because it is not actually being uploaded, we are just faking it
        return $this->fakeImageUpload(new File($targetPath));
    }

    /**
     * Take a fixture image file and move it to the public directory
     *
     * @param File $image
     *
     * @return string
     */
    private function fakeImageUpload(File $image)
    {
        $uploadDirectory = 'uploads/images/fixtures';
        $path = $this->kernel->getProjectDir().'/public/'.$uploadDirectory;

        $originalFilename = $image->getFilename();
        $imageName = $originalFilename;

        $image->move($path, $imageName);

        return '/'.$uploadDirectory.'/'.$imageName;
    }
}
