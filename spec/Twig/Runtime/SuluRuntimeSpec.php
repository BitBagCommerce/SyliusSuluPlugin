<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusSuluPlugin\Twig\Runtime;

use BitBag\SyliusSuluPlugin\ApiClient\SuluApiClientInterface;
use BitBag\SyliusSuluPlugin\Renderer\Block\SuluBlockRendererStrategyInterface;
use BitBag\SyliusSuluPlugin\Renderer\Page\SuluPageRendererStrategyInterface;
use BitBag\SyliusSuluPlugin\Twig\Runtime\SuluRuntime;
use PhpSpec\ObjectBehavior;

class SuluRuntimeSpec extends ObjectBehavior
{
    function let(
        SuluApiClientInterface $suluApiClient,
        SuluBlockRendererStrategyInterface $blockRendererStrategy,
        SuluPageRendererStrategyInterface $pageRendererStrategy,
    ) {
        $this->beConstructedWith($suluApiClient, $blockRendererStrategy, $pageRendererStrategy);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SuluRuntime::class);
    }

    function it_fetches_sulu_page_from_api_client(SuluApiClientInterface $suluApiClient)
    {
        $id = 'example-page-id';
        $page = ['id' => $id, 'title' => 'Example Page'];

        $suluApiClient->fetchCmsContent($id)->willReturn($page);

        $this->getSuluPage($id)->shouldReturn($page);
    }

    function it_renders_sulu_page_using_page_renderer_strategy(
        SuluApiClientInterface $suluApiClient,
        SuluPageRendererStrategyInterface $pageRendererStrategy,
    ) {
        $id = 'example-page-id';
        $page = ['id' => $id, 'title' => 'Example Page'];
        $renderedPage = '<html><body><h1>Example Page</h1></body></html>';

        $suluApiClient->fetchCmsContent($id)->willReturn($page);
        $pageRendererStrategy->renderPage($page)->willReturn($renderedPage);

        $this->renderSuluPage($id)->shouldReturn($renderedPage);
    }

    function it_renders_sulu_blocks_using_block_renderer_strategy(
        SuluBlockRendererStrategyInterface $blockRendererStrategy,
    ) {
        $blocks = [['type' => 'block-type-1'], ['type' => 'block-type-2']];
        $renderedBlocks = '<div>Block 1</div><hr><div>Block 2</div><hr>';
        $divider = '<hr>';

        $blockRendererStrategy->renderBlock($blocks[0])->willReturn('<div>Block 1</div>');
        $blockRendererStrategy->renderBlock($blocks[1])->willReturn('<div>Block 2</div>');

        $this->renderSuluBlocks($blocks, $divider)->shouldReturn($renderedBlocks);
    }

    function it_renders_sulu_blocks_with_specified_type_using_block_renderer_strategy(
        SuluBlockRendererStrategyInterface $blockRendererStrategy,
    ) {
        $blocks = [['type' => 'block-type-1'], ['type' => 'block-type-2'], ['type' => 'block-type-1']];
        $filteredBlocks = [['type' => 'block-type-1'], ['type' => 'block-type-1']];
        $renderedBlocks = '<div>Block 1</div><hr><div>Block 1</div><hr>';
        $divider = '<hr>';

        $blockRendererStrategy->renderBlock($filteredBlocks[0])->willReturn('<div>Block 1</div>');
        $blockRendererStrategy->renderBlock($filteredBlocks[1])->willReturn('<div>Block 1</div>');

        $this->renderSuluBlocksWithType($blocks, 'block-type-1', $divider)->shouldReturn($renderedBlocks);
    }

    function it_renders_first_sulu_block_with_specified_type_using_block_renderer_strategy(
        SuluBlockRendererStrategyInterface $blockRendererStrategy,
    ) {
        $blocks = [['type' => 'block-type-1', 'content' => 'Block 1 content'], ['type' => 'block-type-2']];
        $filteredBlocks = [['type' => 'block-type-1', 'content' => 'Block 1 content']];
        $renderedBlock = '<div>Block 1</div>';

        $blockRendererStrategy->renderBlock($filteredBlocks[0])->willReturn('<div>Block 1</div>');

        $this->renderSuluBlockWithType($blocks, 'block-type-1')->shouldReturn($renderedBlock);
    }
}
