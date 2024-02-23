<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Twig\Runtime;

use BitBag\SyliusSuluPlugin\ApiClient\SuluApiClientInterface;
use BitBag\SyliusSuluPlugin\Renderer\Block\SuluBlockRendererStrategyInterface;
use BitBag\SyliusSuluPlugin\Renderer\Page\SuluPageRendererStrategyInterface;

final class SuluRuntime implements SuluRuntimeInterface
{
    public function __construct(
        private SuluApiClientInterface $suluApiClient,
        private SuluBlockRendererStrategyInterface $blockRendererStrategy,
        private SuluPageRendererStrategyInterface $pageRendererStrategy,
    ) {
    }

    public function getSuluPage(string $id): array
    {
        return $this->suluApiClient->fetchCmsContent($id);
    }

    public function renderSuluPage(string $id): string
    {
        $page = $this->getSuluPage($id);

        $content = $this->pageRendererStrategy->renderPage($page);

        return $content;
    }

    public function renderSuluBlocks(array $blocks, ?string $divider = null): string
    {
        $content = '';

        foreach ($blocks as $block) {
            $content .= $this->blockRendererStrategy->renderBlock($block);
            $content .= $divider;
        }

        return $content;
    }

    public function renderSuluBlocksWithType(array $blocks, string $type, ?string $divider = null): string
    {
        $blocks = array_filter($blocks, fn (array $block) => $block['type'] === $type);
        $content = '';

        foreach ($blocks as $block) {
            $content .= $this->blockRendererStrategy->renderBlock($block);
            $content .= $divider;
        }

        return $content;
    }

    public function renderSuluBlockWithType(array $blocks, string $type): string
    {
        $blocks = array_filter($blocks, fn (array $block) => $block['type'] === $type);
        if (count($blocks) > 1) {
            $blocks = $blocks[0];
        }

        $content = '';

        foreach ($blocks as $block) {
            $content .= $this->blockRendererStrategy->renderBlock($block);
        }

        return $content;
    }

    public function hasSuluBlock(array $page, string $type): bool
    {
        if (!array_key_exists('blocks', $page)) {
            return false;
        }

        $blocks = $page['blocks'];

        if (0 === count($blocks)) {
            return false;
        }

        $blocks = array_filter($blocks, fn (array $block) => $block['type'] === $type);

        return 0 !== count($blocks);
    }
}
