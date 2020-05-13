<?php

namespace App\Entity;

use App\Repository\MaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaskRepository::class)
 */
class Mask extends Product
{
}
