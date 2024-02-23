<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusSuluPlugin\Application\src\Renderer\Block;

use BitBag\SyliusSuluPlugin\Renderer\Block\SuluBlockRenderStrategyInterface;
use Twig\Environment;

class ImageRenderer implements SuluBlockRenderStrategyInterface
{
    public const IMAGE = 'image';

    public function __construct(
        private Environment $twig,
    ) {
    }

    public function support(array $blockData): bool
    {
        return array_key_exists('type', $blockData) &&
            in_array($blockData['type'], $this->getAllowedBlocks(), true) &&
            $this->twig->getLoader()->exists($this->getTemplate())
        ;
    }

    public function render(array $blockData): string
    {
        return $this->twig->render(
            $this->getTemplate(),
            [
                'url' => $blockData['url'],
                'alt' => $blockData['alt'],
            ],
        );
    }

    public function getAllowedBlocks(): array
    {
        return [self::IMAGE];
    }

    public function getTemplate(): string
    {
        return '@BitBagSyliusSuluPlugin/shop/block/image.html.twig';
    }
}
