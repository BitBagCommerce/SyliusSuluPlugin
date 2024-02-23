<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusSuluPlugin\Behat\Page;

use Sylius\Behat\Page\Shop\HomePage as BaseHomePage;

class HomePage extends BaseHomePage
{
    public function getFeaturedPages(): ?array
    {
        return $this->getDocument()
            ->find('css', 'div.featured-pages')
            ->findAll('css', 'div.ui.fluid.card')
        ;
    }
}
