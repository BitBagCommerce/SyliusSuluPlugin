<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
