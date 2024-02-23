<?php

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
