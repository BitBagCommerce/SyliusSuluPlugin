<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusSuluPlugin\Renderer\Page;

use BitBag\SyliusSuluPlugin\Renderer\Page\SuluPageRendererStrategy;
use BitBag\SyliusSuluPlugin\Renderer\Page\SuluPageRenderStrategyInterface;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Twig\Error\Error;

class SuluPageRendererStrategySpec extends ObjectBehavior
{
    function let(
        SuluPageRenderStrategyInterface $pageRenderer1,
        SuluPageRenderStrategyInterface $pageRenderer2,
        LoggerInterface $logger,
    ) {
        $this->beConstructedWith([$pageRenderer1, $pageRenderer2], $logger);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SuluPageRendererStrategy::class);
    }

    function it_throws_runtime_error_if_no_renderer_is_found(
        SuluPageRenderStrategyInterface $pageRenderer1,
        SuluPageRenderStrategyInterface $pageRenderer2,
    ) {
        $page = ['template' => 'non-existing-template'];

        $pageRenderer1->support($page)->willReturn(false);
        $pageRenderer2->support($page)->willReturn(false);

        $this->shouldThrow(\Twig\Error\RuntimeError::class)->during('renderPage', [$page]);
    }

    function it_returns_rendered_page_content(
        SuluPageRenderStrategyInterface $pageRenderer1,
        SuluPageRenderStrategyInterface $pageRenderer2,
    ) {
        $page = ['template' => 'existing-template', 'data' => []];
        $renderedContent = '<html><body><h1>Rendered Page</h1></body></html>';

        $pageRenderer1->support($page)->willReturn(false);
        $pageRenderer2->support($page)->willReturn(true);
        $pageRenderer2->render($page)->willReturn($renderedContent);

        $this->renderPage($page)->shouldReturn($renderedContent);
    }

    function it_returns_empty_string_on_render_error(
        SuluPageRenderStrategyInterface $pageRenderer1,
        SuluPageRenderStrategyInterface $pageRenderer2,
    ) {
        $page = ['template' => 'existing-template', 'data' => []];

        $pageRenderer1->support($page)->willReturn(false);
        $pageRenderer2->support($page)->willReturn(true);
        $pageRenderer2->render($page)->willThrow(Error::class);

        $this->renderPage($page)->shouldReturn('');
    }
}
