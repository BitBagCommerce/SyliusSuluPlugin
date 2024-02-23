<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusSuluPlugin\Application\src\Renderer\Page;

use BitBag\SyliusSuluPlugin\Renderer\Page\SuluPageRenderStrategyInterface;
use Twig\Environment;

class FeaturedPagesRenderer implements SuluPageRenderStrategyInterface
{
    public const BLOG_PAGE = 'featured_pages';

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
        return [self::BLOG_PAGE];
    }

    public function getTemplate(): string
    {
        return '@BitBagSyliusSuluPlugin/shop/page/featuredPages.html.twig';
    }
}
