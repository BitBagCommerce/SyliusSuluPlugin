<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Renderer\Page;

interface SuluPageRenderStrategyInterface
{
    public const TYPE = 'type';

    public function support(array $page): bool;

    public function render(array $page): string;

    public function getAllowedPageTemplates(): array;

    public function getTemplate(): string;
}
