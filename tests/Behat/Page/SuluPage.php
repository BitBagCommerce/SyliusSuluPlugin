<?php

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
