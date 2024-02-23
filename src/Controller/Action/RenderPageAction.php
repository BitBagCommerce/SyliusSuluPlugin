<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Controller\Action;

use BitBag\SyliusSuluPlugin\ApiClient\SuluApiClientInterface;
use BitBag\SyliusSuluPlugin\Renderer\Page\SuluPageRendererStrategyInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

final class RenderPageAction
{
    public function __construct(
        private SuluApiClientInterface $suluApiClient,
        private SuluPageRendererStrategyInterface $pageRendererStrategy,
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
            return new Response('', 404);
        }

        return new Response($page);
    }
}
