<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusSuluPlugin\Behat\Page;

use Behat\Mink\Element\NodeElement;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class SuluPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'bitbag_render_sulu_page';
    }

    public function findElement(string $element): ?NodeElement
    {
        $document = $this->getDocument();

        return match ($element) {
            'title' => $document->find('css', '#page-title'),
            'content' => $document->find('css', '#page-content'),
        };
    }

    public function findBlockElement(string $element): ?NodeElement
    {
        $document = $this->getDocument();

        return match ($element) {
            'image' => $document->find('css', '#block-image'),
            'quote' => $document->find('css', '#block-quote'),
            'content' => $document->find('css', '#block-content'),
        };
    }
}
