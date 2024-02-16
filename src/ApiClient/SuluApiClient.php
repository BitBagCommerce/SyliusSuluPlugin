<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\ApiClient;

use Sylius\Component\Core\Context\ShopperContextInterface;
use Symfony\Component\HttpClient\CachingHttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class SuluApiClient
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

        $locale = null;
        if ($channel->isSuluUseLocalizationUrl()) {
            $locale = $this->shopperContext->getLocaleCode();
        }

        $store = new Store(sprintf(
            '%s/%s/%s',
            $this->cacheDir,
            $channel->getCode() ?? 'GLOBAL',
            $locale,
        ));

        $this->client = new CachingHttpClient($this->client, $store);

        $url = $this->createUrl($url, strtolower($locale));

        try {
            $response = $this->makeApiCall($url);
        } catch (\Exception $e) {
            return [];
        }

        return json_decode($response->getContent(), true);
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
        if (null === $locale) {
            return sprintf('%s/%s.json', $this->suluBaseUri, $url);
        }

        return sprintf('%s/%s/%s.json', $this->suluBaseUri, $locale, $url);
    }
}
