<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Controller\Action;

use BitBag\SyliusSuluPlugin\ApiClient\SuluApiClient;
use BitBag\SyliusSuluPlugin\Renderer\Page\SuluPageRendererStrategy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

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
        $secondSlug = $request->get('second_slug');

        Assert::string($url);

        if (is_string($secondSlug) && strlen($secondSlug) !== 0) {
            $url = sprintf('%s/%s', $url, $secondSlug);
        }

        $page = $this->suluApiClient->fetchCmsContent($url);
        $page = $this->pageRendererStrategy->renderPage($page);

        if (strlen($page) === 0) {
            return new Response(null, 404);
        }

        return new Response($page);
    }
}
