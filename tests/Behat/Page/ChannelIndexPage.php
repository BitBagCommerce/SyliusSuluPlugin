<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusSuluPlugin\Behat\Page;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Channel\IndexPage;

class ChannelIndexPage extends IndexPage
{
    public function findAPurgeCacheButton(): ?NodeElement
    {
        return $this->getDocument()->find('css', '[data-test-button="bitbag.sulu_plugin.purge_channel_cache"]');
    }

    public function findAPurgeCacheButtonWithLocales(): ?NodeElement
    {
        return $this->getDocument()->find('css', 'div.select-locale');
    }
}
