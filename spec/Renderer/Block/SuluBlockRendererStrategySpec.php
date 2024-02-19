<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusSuluPlugin\Renderer\Block;

use BitBag\SyliusSuluPlugin\Renderer\Block\SuluBlockRendererStrategy;
use BitBag\SyliusSuluPlugin\Renderer\Block\SuluBlockRenderStrategyInterface;
use PhpSpec\ObjectBehavior;
use Twig\Error\Error;
use Twig\Error\RuntimeError;

class SuluBlockRendererStrategySpec extends ObjectBehavior
{
    function let(SuluBlockRenderStrategyInterface $blockRenderer1, SuluBlockRenderStrategyInterface $blockRenderer2)
    {
        $this->beConstructedWith([$blockRenderer1, $blockRenderer2]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SuluBlockRendererStrategy::class);
    }

    function it_throws_runtime_error_if_no_renderer_is_found(
        SuluBlockRenderStrategyInterface $blockRenderer1,
        SuluBlockRenderStrategyInterface $blockRenderer2,
    ) {
        $blockData = ['type' => 'non-existing-type'];

        $blockRenderer1->support($blockData)->willReturn(false);
        $blockRenderer2->support($blockData)->willReturn(false);

        $this->shouldThrow(RuntimeError::class)->during('renderBlock', [$blockData]);
    }

    function it_returns_rendered_block_content(
        SuluBlockRenderStrategyInterface $blockRenderer1,
        SuluBlockRenderStrategyInterface $blockRenderer2,
    ) {
        $blockData = ['type' => 'existing-type', 'data' => []];
        $renderedContent = '<div>Rendered content</div>';

        $blockRenderer1->support($blockData)->willReturn(false);
        $blockRenderer2->support($blockData)->willReturn(true);
        $blockRenderer2->render($blockData)->willReturn($renderedContent);

        $this->renderBlock($blockData)->shouldReturn($renderedContent);
    }

    function it_returns_empty_string_on_render_error(
        SuluBlockRenderStrategyInterface $blockRenderer1,
        SuluBlockRenderStrategyInterface $blockRenderer2,
    ) {
        $blockData = ['type' => 'existing-type', 'data' => []];

        $blockRenderer1->support($blockData)->willReturn(false);
        $blockRenderer2->support($blockData)->willReturn(true);
        $blockRenderer2->render($blockData)->willThrow(Error::class);

        $this->renderBlock($blockData)->shouldReturn('');
    }
}
