<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

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
            new TwigFunction('bitbag_page_has_sulu_block', [$this->suluRuntime, 'hasSuluBlock']),
        ];
    }
}
