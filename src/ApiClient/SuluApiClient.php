<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\ApiClient;

use Sylius\Component\Core\Context\ShopperContextInterface;
use Symfony\Component\HttpClient\CachingHttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpCache\Store;
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
        $locale = '';
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

        $store = new Store($storeRoot);

        $this->client = new CachingHttpClient($this->client, $store);

        $url = $this->createUrl($url, strtolower($locale));

        try {
            $response = $this->makeApiCall($url);
        } catch (\Exception $e) {
            return [];
        }

        $response = json_decode($response->getContent(), true);

        Assert::isArray($response);

        return $response;
    }

    private function makeApiCall(string $url): ResponseInterface
    {
        return $this->client->request(
            Request::METHOD_GET,
            $url,
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ],
        );
    }

    private function createUrl(string $url, ?string $locale = null): string
    {
        if (null === $locale || strlen($locale) === 0) {
            return sprintf('%s/%s.json', $this->suluBaseUri, $url);
        }

        return sprintf('%s/%s/%s.json', $this->suluBaseUri, $locale, $url);
    }
}
