<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusSuluPlugin\Application\src\Renderer\Block;

use BitBag\SyliusSuluPlugin\Renderer\Block\SuluBlockRenderStrategyInterface;
use Twig\Environment;

class QuoteRenderer implements SuluBlockRenderStrategyInterface
{
    public const TYPE = 'quote';

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
                'quote' => $blockData['quote'],
                'quoteReference' => $blockData['quoteReference'],
            ],
        );
    }

    public function getAllowedBlocks(): array
    {
        return [self::TYPE];
    }

    public function getTemplate(): string
    {
        return '@BitBagSyliusSuluPlugin/shop/block/quote.html.twig';
    }
}
