<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusSuluPlugin\Application\src\Renderer\Block;

use BitBag\SyliusSuluPlugin\Renderer\Block\SuluBlockRenderStrategyInterface;
use Twig\Environment;

class TextRenderer implements SuluBlockRenderStrategyInterface
{
    public const TYPE = 'text';

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
                'title' => $blockData['title'],
                'description' => $blockData['content'],
                'tags' => $blockData['tags'],
            ],
        );
    }

    public function getAllowedBlocks(): array
    {
        return [self::TYPE];
    }

    public function getTemplate(): string
    {
        return '@BitBagSyliusSuluPlugin/shop/block/text.html.twig';
    }
}
