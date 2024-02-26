<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
