<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusSuluPlugin\ApiClient;

use BitBag\SyliusSuluPlugin\ApiClient\SuluApiClient;
use BitBag\SyliusSuluPlugin\ApiClient\SuluApiClientInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Context\ShopperContextInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SuluApiClientSpec extends ObjectBehavior
{
    function let(
        HttpClientInterface $client,
        ShopperContextInterface $shopperContext,
    ) {
        $suluBaseUri = 'http://example.com';
        $cacheDir = '/var/cache/sulu';

        $this->beConstructedWith($client, $shopperContext, $suluBaseUri, $cacheDir);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(SuluApiClient::class);
    }

    public function it_implements_sulu_api_client_interface_interface(): void
    {
        $this->shouldHaveType(SuluApiClientInterface::class);
    }

//    function it_fetches_cms_content(
//        HttpClientInterface $client,
//        ShopperContextInterface $shopperContext,
//        ChannelInterface $channel,
//    ) {
//        $url = '/cms/content';
//        $locale = 'en_US';
//
//        $shopperContext->getChannel()->willReturn($channel);
//        $shopperContext->getLocaleCode()->willReturn($locale);
//        $channel->isSuluUseLocalizedUrls()->willReturn(true);
//
//        $client->request('GET', 'http://example.com/en_US/cms/content.json', ['headers' => ['Accept' => 'application/json']])->shouldBeCalled();
//
//        $this->fetchCmsContent($url);
//    }
//
//    function it_fetches_cms_content_with_global_channel(
//        HttpClientInterface $client,
//        ShopperContextInterface $shopperContext,
//        ChannelInterface $channel,
//    ) {
//        $url = '/cms/content';
//
//        $shopperContext->getChannel()->willReturn($channel);
//        $shopperContext->getLocaleCode()->willReturn(null);
//        $channel->isSuluUseLocalizedUrls()->willReturn(false);
//
//
//        $client->request('GET', 'http://example.com/cms/content.json', ['headers' => ['Accept' => 'application/json']])->shouldBeCalled();
//
//        $this->fetchCmsContent($url);
//    }
}
