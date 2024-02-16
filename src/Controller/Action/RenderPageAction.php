<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Controller\Action;

use BitBag\SyliusSuluPlugin\ApiClient\SuluApiClient;
use BitBag\SyliusSuluPlugin\Renderer\Page\SuluPageRendererStrategy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class RenderPageAction
{
    public function __construct(
        private SuluApiClient $suluApiClient,
        private SuluPageRendererStrategy $pageRendererStrategy,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $url = $request->get('slug');

        if (null !== $request->get('second_slug')) {
            $url = sprintf('%s/%s', $url, $request->get('second_slug'));
        }

        $page = $this->suluApiClient->fetchCmsContent($url);
        $page = $this->pageRendererStrategy->renderPage($page);

        if (null === $page) {
            return new Response(null, 404);
        }

        return new Response($page);
    }
}
