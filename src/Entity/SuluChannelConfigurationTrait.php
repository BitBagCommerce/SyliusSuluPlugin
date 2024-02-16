<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Entity;

trait SuluChannelConfigurationTrait
{
    protected bool $suluUseLocalizationUrl = false;

    public function isSuluUseLocalizationUrl(): bool
    {
        return $this->suluUseLocalizationUrl;
    }

    public function setSuluUseLocalizationUrl(bool $suluUseLocalizationUrl): void
    {
        $this->suluUseLocalizationUrl = $suluUseLocalizationUrl;
    }
}
