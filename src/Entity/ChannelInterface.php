<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Entity;

interface ChannelInterface
{
    public function isSuluUseLocalizedUrls(): bool;

    public function setSuluUseLocalizedUrls(bool $suluUseLocalizedUrls): void;
}
