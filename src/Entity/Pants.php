<?php

namespace App\Entity;

use App\Repository\PantsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PantsRepository::class)
 */
class Pants extends Product
{
}
