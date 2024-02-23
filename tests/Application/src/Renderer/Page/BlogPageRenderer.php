<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusSuluPlugin\Application\src\Renderer\Page;

use BitBag\SyliusSuluPlugin\Renderer\Page\SuluPageRenderStrategyInterface;
use Twig\Environment;

class BlogPageRenderer implements SuluPageRenderStrategyInterface
{
    public const PAGE_TYPE = 'blog';

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
            ['page' => $page['content']],
        );
    }

    public function getAllowedPageTemplates(): array
    {
        return [self::PAGE_TYPE];
    }

    public function getTemplate(): string
    {
        return '@BitBagSyliusSuluPlugin/shop/page/blog.html.twig';
    }
}
