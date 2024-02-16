<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Controller\Action;

use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webmozart\Assert\Assert;

final class PurgeSuluCacheAction
{
    public function __construct(
        private ChannelRepositoryInterface $channelRepository,
        private RequestStack $requestStack,
        private TranslatorInterface $translator,
        private string $cacheDir,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $channelId = $request->get('id');
        $localeCode = $request->get('locale');
        /** @var ChannelInterface $channel */
        $channel = $this->channelRepository->find($channelId);

        $cacheDir = sprintf('%s/%s', $this->cacheDir, $channel->getCode() ?? 'GLOBAL');

        if (is_string($localeCode) && strlen($localeCode) !== 0) {
            $cacheDir = sprintf('%s/%s/%s', $this->cacheDir, $channel->getCode() ?? 'GLOBAL', $localeCode);
        }

        $referer = $request->server->get('HTTP_REFERER');

        Assert::string($referer);

        $response = new RedirectResponse($referer, 302);

        if (!is_dir($cacheDir)) {
            $this->addFlash('error', 'bitbag.sulu_plugin.cache.dir_not_exists');

            return $response;
        }

        try {
            $this->removeDir($cacheDir);
        } catch (\Exception $exception) {
            $this->addFlash('error', 'bitbag.sulu_plugin.cache.something_goes_wrong');

            return $response;
        }

        $this->addFlash('success', 'bitbag.sulu_plugin.cache.successful_purged');

        return $response;
    }

    private function removeDir(string $dir): void
    {
        $iterator = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);

        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }

        rmdir($dir);
    }

    private function addFlash(string $type, string $translation): void
    {
        $session = $this->requestStack->getSession();

        Assert::methodExists($session, 'getFlashBag');

        $flashbag = $session->getFlashBag();

        $flashbag->add(
            $type,
            $this->translator->trans(
                $translation,
                domain: 'flashes',
            ),
        );
    }
}
