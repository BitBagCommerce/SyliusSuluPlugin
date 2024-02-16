<?php

declare(strict_types=1);

namespace BitBag\SyliusSuluPlugin\Controller\Action;

use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

final class PurgeSuluCacheAction
{
    public function __construct(
        private ChannelRepositoryInterface $channelRepository,
        private RequestStack $requestStack,
        private TranslatorInterface $translator,
        private string $cacheDir,
    ) {
    }

    public function __invoke(Request $request)
    {
        $channelId = $request->get('id');
        $localeCode = $request->get('locale');
        $channel = $this->channelRepository->find($channelId);
        $cacheDir = sprintf('%s/%s', $this->cacheDir, $channel->getCode() ?? 'GLOBAL');

        if (null !== $localeCode) {
            $cacheDir = sprintf('%s/%s/%s', $this->cacheDir, $localeCode, $channel->getCode() ?? 'GLOBAL');
        }

        $response = new RedirectResponse($request->server->get('HTTP_REFERER'), 302);

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

        $this->addFlash('success', 'bitbag.sulu_plugin.cache.successful_purged', );

        return $response;
    }

    private function removeDir(string $dir): void
    {
        $iterator = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);

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
        $flashbag = $this->requestStack->getSession()->getFlashBag();

        $flashbag->add(
            'success',
            $this->translator->trans(
                'bitbag.sulu_plugin.cache.successful_purged',
                domain: 'flashes',
            ),
        );
    }
}
