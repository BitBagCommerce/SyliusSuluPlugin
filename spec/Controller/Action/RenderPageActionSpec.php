<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusSuluPlugin\Controller\Action;

use BitBag\SyliusSuluPlugin\ApiClient\SuluApiClientInterface;
use BitBag\SyliusSuluPlugin\Controller\Action\RenderPageAction;
use BitBag\SyliusSuluPlugin\Renderer\Page\SuluPageRendererStrategyInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RenderPageActionSpec extends ObjectBehavior
{
    function let(
        SuluApiClientInterface $suluApiClient,
        SuluPageRendererStrategyInterface $pageRendererStrategy,
        Request $request,
    ) {
        $this->beConstructedWith($suluApiClient, $pageRendererStrategy);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RenderPageAction::class);
    }

    function it_returns_response_for_valid_url(
        SuluApiClientInterface $suluApiClient,
        SuluPageRendererStrategyInterface $pageRendererStrategy,
        Request $request,
    ) {
        $url = 'example-page';
        $pageContent = '<html><body><h1>Example Page</h1></body></html>';

        $request->get('slug')->willReturn($url);
        $request->get('second_slug')->willReturn(null);

        $suluApiClient->fetchCmsContent($url)->willReturn(['content' => $pageContent]);
        $pageRendererStrategy->renderPage(['content' => $pageContent])->willReturn($pageContent);

        $this->__invoke($request)->shouldBeAnInstanceOf(Response::class);
        $this->__invoke($request)->getContent()->shouldReturn($pageContent);
    }

    function it_returns_response_for_valid_url_with_second_slug(
        SuluApiClientInterface $suluApiClient,
        SuluPageRendererStrategyInterface $pageRendererStrategy,
        Request $request,
    ) {
        $url = 'example-page';
        $secondSlug = 'second-slug';
        $fullUrl = "{$url}/{$secondSlug}";
        $pageContent = '<html><body><h1>Example Page</h1></body></html>';

        $request->get('slug')->willReturn($url);
        $request->get('second_slug')->willReturn($secondSlug);

        $suluApiClient->fetchCmsContent($fullUrl)->willReturn(['content' => $pageContent]);
        $pageRendererStrategy->renderPage(['content' => $pageContent])->willReturn($pageContent);

        $this->__invoke($request)->shouldBeAnInstanceOf(Response::class);
        $this->__invoke($request)->getContent()->shouldReturn($pageContent);
    }

    function it_returns_404_response_for_unknown_url(
        SuluApiClientInterface $suluApiClient,
        Request $request,
        SuluPageRendererStrategyInterface $pageRendererStrategy,
    ) {
        $url = 'non-existing-page';

        $request->get('slug')->willReturn($url);
        $request->get('second_slug')->willReturn(null);

        $suluApiClient->fetchCmsContent($url)->willReturn([]);
        $pageRendererStrategy->renderPage([])->willReturn('');

        $response = $this->__invoke($request);
        $response->shouldBeAnInstanceOf(Response::class);
        $response->getStatusCode()->shouldReturn(404);
    }
}
