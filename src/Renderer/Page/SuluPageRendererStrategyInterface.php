<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Renderer\Page;

interface SuluPageRendererStrategyInterface
{
    public function renderPage(array $page): string;
}
