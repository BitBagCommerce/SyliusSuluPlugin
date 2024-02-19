<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Renderer\Block;

interface SuluBlockRendererStrategyInterface
{
    public function renderBlock(array $blockData): string;
}
