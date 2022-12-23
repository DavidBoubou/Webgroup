<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\PageBundle\Entity\BaseBlock;
use Doctrine\DBAL\Types\Types;
use App\Repository\SonataPageBlockRepository;
/**
 * @ORM\Entity
 * @ORM\Table(name="page__block")
 */
#[ORM\Entity(repositoryClass: SonataPageBlockRepository::class)]
class SonataPageBlock extends BaseBlock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected $id = null;
}
