<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Twig\Extension;

use BitBag\SyliusSuluPlugin\Twig\Runtime\SuluRuntimeInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class SuluPageExtension extends AbstractExtension
{
    public function __construct(
        private SuluRuntimeInterface $suluRuntime,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('bitbag_get_sulu_page', [$this->suluRuntime, 'getSuluPage']),
            new TwigFunction('bitbag_render_sulu_page', [$this->suluRuntime, 'renderSuluPage']),
            new TwigFunction('bitbag_render_sulu_blocks', [$this->suluRuntime, 'renderSuluBlocks']),
            new TwigFunction('bitbag_render_sulu_blocks_with_type', [$this->suluRuntime, 'renderSuluBlocksWithType']),
            new TwigFunction('bitbag_render_sulu_block_with_type', [$this->suluRuntime, 'renderSuluBlockWithType']),
        ];
    }
}
