<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\PageBundle\Entity\BaseSnapshot;
use Doctrine\DBAL\Types\Types;
use App\Repository\SonataPageSnapshotRepository;

/**
 * @ORM\Entity(repositoryClass= SonataPageSnapshotRepository::class)
 * @ORM\Table(name="page__snapshot", indexes={
 *     @ORM\Index(
 *         name="idx_snapshot_dates_enabled", columns={"publication_date_start", "publication_date_end","enabled"
 *     })
 * })
 */
#[ORM\Entity(repositoryClass: SonataPageSnapshotRepository::class)]
class SonataPageSnapshot extends BaseSnapshot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected $id = null;

}
