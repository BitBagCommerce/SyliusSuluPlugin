<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Twig\Runtime;

use BitBag\SyliusSuluPlugin\ApiClient\SuluApiClientInterface;
use BitBag\SyliusSuluPlugin\Renderer\Block\SuluBlockRendererStrategyInterface;
use BitBag\SyliusSuluPlugin\Renderer\Page\SuluPageRendererStrategyInterface;

class SuluRuntime implements SuluRuntimeInterface
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
}
