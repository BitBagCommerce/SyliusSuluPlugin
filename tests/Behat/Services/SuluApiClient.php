<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusSuluPlugin\Behat\Services;

use BitBag\SyliusSuluPlugin\ApiClient\SuluApiClientInterface;
use Sylius\Component\Core\Context\ShopperContextInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Webmozart\Assert\Assert;

final class SuluApiClient implements SuluApiClientInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private ShopperContextInterface $shopperContext,
        private string $suluBaseUri,
        private string $cacheDir,
    ) {
    }

    public function fetchCmsContent(string $url): array
    {
        $channel = $this->shopperContext->getChannel();
        $storeRoot = sprintf(
            '%s/%s',
            $this->cacheDir,
            $channel->getCode() ?? 'GLOBAL',
        );

        Assert::methodExists($channel, 'isSuluUseLocalizedUrls');

        if ($channel->isSuluUseLocalizedUrls()) {
            $locale = $this->shopperContext->getLocaleCode();
            $storeRoot = sprintf('%s/%s', $storeRoot, $locale);
        }
        $cache = new FilesystemAdapter(defaultLifetime: 3600, directory: $storeRoot);

        $this->client =
            new MockHttpClient(
                $this->mockResponses()[$url],
                $this->suluBaseUri,
            );

        try {
            $response = $cache->get(
                $url,
                function (ItemInterface $cacheItem) use ($url) {
                    $response = $this->makeApiCall($url);

                    $response = json_decode($response->getContent(), true);
                    Assert::isArray($response);

                    $cacheItem->set($response);
                    $cacheItem->expiresAfter(3600);

                    return $response;
                },
            );
        } catch (\Exception $e) {
            return [];
        }

        return $response;
    }

    private function makeApiCall(string $url): ResponseInterface
    {
        $response = $this->client->request(
            Request::METHOD_GET,
            $url,
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ],
        );

        return $response;
    }

    private function mockResponses(): array
    {
        $featured = file_get_contents(__DIR__ . '/../ApiResponseMock/featured_pages.json');
        $pageWithProperties = file_get_contents(__DIR__ . '/../ApiResponseMock/blog_page_with_properties.json');
        $pageWithBlocks = file_get_contents(__DIR__ . '/../ApiResponseMock/blog_page_with_blocks_and_links.json');

        return [
           'featured_pages' => new MockResponse($featured, ['http_code' => 200]),
           'blog_page_with_properties' => new MockResponse($pageWithProperties, ['http_code' => 200]),
           'blog_page_with_blocks_and_links' => new MockResponse($pageWithBlocks, ['http_code' => 200]),
        ];
    }
}
