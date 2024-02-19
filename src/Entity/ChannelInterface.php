<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Entity;

use Sylius\Component\Core\Model\ChannelInterface as BaseChannelInterface;

interface ChannelInterface extends BaseChannelInterface
{
    public function isSuluUseLocalizedUrls(): bool;

    public function setSuluUseLocalizedUrls(bool $suluUseLocalizedUrls): void;
}
