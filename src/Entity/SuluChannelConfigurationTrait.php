<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Entity;

trait SuluChannelConfigurationTrait
{
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
