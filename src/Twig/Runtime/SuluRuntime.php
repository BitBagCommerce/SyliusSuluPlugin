<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Twig\Runtime;

use BitBag\SyliusSuluPlugin\ApiClient\SuluApiClient;
use BitBag\SyliusSuluPlugin\Renderer\Block\SuluBlockRendererStrategy;
use BitBag\SyliusSuluPlugin\Renderer\Page\SuluPageRendererStrategy;

class SuluRuntime implements SuluRuntimeInterface
{
    public function __construct(
        private SuluApiClient $suluApiClient,
        private SuluBlockRendererStrategy $blockRendererStrategy,
        private SuluPageRendererStrategy $pageRendererStrategy,
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
        $content = null;

        foreach ($blocks as $block) {
            $content .= $this->blockRendererStrategy->renderBlock($block);
            $content .= $divider;
        }

        return $content;
    }

    public function renderSuluBlocksWithType(array $blocks, string $type, ?string $divider = null): string
    {
        $blocks = array_filter($blocks, fn (array $block) => $block['type'] === $type);
        $content = null;

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
        $content = null;

        foreach ($blocks as $block) {
            $content .= $this->blockRendererStrategy->renderBlock($block);
        }

        return $content;
    }
}
