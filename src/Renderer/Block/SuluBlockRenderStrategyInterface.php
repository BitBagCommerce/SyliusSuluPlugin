<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Renderer\Block;

interface SuluBlockRenderStrategyInterface
{
    public function support(array $blockData): bool;

    public function render(array $blockData): string;

    public function getAllowedBlocks(): array;

    public function getTemplate(): string;
}
