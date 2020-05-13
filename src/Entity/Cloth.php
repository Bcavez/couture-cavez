<?php

namespace App\Entity;

use App\Repository\ClothRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClothRepository::class)
 */
class Cloth extends Product
{
}
