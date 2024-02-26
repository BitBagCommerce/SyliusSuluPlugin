<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusSuluPlugin\Application\src\Renderer\Page;

use BitBag\SyliusSuluPlugin\Renderer\Page\SuluPageRenderStrategyInterface;
use Twig\Environment;

class FeaturedPagesRenderer implements SuluPageRenderStrategyInterface
{
    public const PAGE_TYPE = 'featured_pages';

    public function __construct(
        private Environment $twig,
    ) {
    }

    public function support(array $page): bool
    {
        return array_key_exists('type', $page) &&
            $page['type'] === 'page' &&
            array_key_exists('template', $page) &&
            in_array($page['template'], $this->getAllowedPageTemplates(), true) &&
            $this->twig->getLoader()->exists($this->getTemplate())
        ;
    }

    public function render(array $page): string
    {
        return $this->twig->render(
            $this->getTemplate(),
            [
                'page' => $page['content'],
                'links' => $page['content']['links'],
            ],
        );
    }

    public function getAllowedPageTemplates(): array
    {
        return [self::PAGE_TYPE];
    }

    public function getTemplate(): string
    {
        return '@BitBagSyliusSuluPlugin/shop/page/featuredPages.html.twig';
    }
}
