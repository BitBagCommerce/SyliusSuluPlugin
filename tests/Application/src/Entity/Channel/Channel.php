<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusSuluPlugin\Application\src\Entity\Channel;

use BitBag\SyliusSuluPlugin\Entity\SuluChannelConfigurationTrait;
use Sylius\Component\Core\Model\Channel as BaseChannel;

class Channel extends BaseChannel
{
    use SuluChannelConfigurationTrait;
}
