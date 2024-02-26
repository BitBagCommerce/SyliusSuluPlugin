<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusSuluPlugin\Controller\Action;

use BitBag\SyliusSuluPlugin\Controller\Action\PurgeSuluCacheAction;
use BitBag\SyliusSuluPlugin\Entity\ChannelInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface as BaseChannelInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\ServerBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Contracts\Translation\TranslatorInterface;

final class PurgeSuluCacheActionSpec extends ObjectBehavior
{
    function let(
        ChannelRepositoryInterface $channelRepository,
        RequestStack $requestStack,
        TranslatorInterface $translator,
    ) {
        $cacheDir = '/path/to/cache';

        $this->beConstructedWith($channelRepository, $requestStack, $translator, $cacheDir);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PurgeSuluCacheAction::class);
    }

    function it_returns_response(
        ChannelRepositoryInterface $channelRepository,
        ChannelInterface $channel,
        RequestStack $requestStack,
        Request $request,
        ServerBag $serverBag,
        Session $session,
        FlashBagInterface $flashbag,
    ) {
        $channelId = 1;
        $localeCode = 'en_US';
        $referer = 'http://example.com';

        $request->get('id')->willReturn($channelId);
        $request->get('locale')->willReturn($localeCode);
        $request->server = $serverBag;
        $serverBag->get('HTTP_REFERER')->willReturn($referer);
        $session->getFlashBag()->willReturn($flashbag);

        $channel->implement(BaseChannelInterface::class);
        $channel->getCode()->willReturn('TEST');
        $channelRepository->find($channelId)->willReturn($channel);

        $requestStack->getSession()->willReturn($session);

        $this->__invoke($request)->shouldBeAnInstanceOf(RedirectResponse::class);
    }
}
