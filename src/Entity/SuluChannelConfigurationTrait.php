<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 * @ORM\Table(name="sylius_channel")
 */
#[ORM\Entity]
#[ORM\Table(name: 'sylius_channel')]
trait SuluChannelConfigurationTrait
{
    /** @ORM\Column(type="boolean", nullable=false) */
    protected bool $suluUseLocalizedUrls = false;

    public function isSuluUseLocalizedUrls(): bool
    {
        return $this->suluUseLocalizedUrls;
    }

    public function setSuluUseLocalizedUrls(bool $suluUseLocalizedUrls): void
    {
        $this->suluUseLocalizedUrls = $suluUseLocalizedUrls;
    }
}
