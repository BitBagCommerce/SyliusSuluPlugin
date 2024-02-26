<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusSuluPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;
use Tests\BitBag\SyliusSuluPlugin\Behat\Services\SuluApiClient;
use Webmozart\Assert\Assert;

final class SuluPageContext implements Context
{
    public function __construct(
        private SuluApiClient $apiClient,
        private SharedStorageInterface $sharedStorage,
        private string $suluCacheDirectory,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @Given Sulu has defined page :page in locale :locale
     */
    public function suluHasPageInLocale(string $page, string $locale)
    {
        $response = $this->apiClient->fetchCmsContent($page);

        $jsonResponse = sprintf('%s/../../ApiResponseMock/%s.json', __DIR__, $page);

        Assert::eq($response, json_decode(file_get_contents($jsonResponse), true));

        $this->sharedStorage->set($page, $response);
    }

    /**
     * @Given Sulu has defined featured pages list :featured_pages in locale :locale
     */
    public function suluHasFeaturedPagesInLocale(string $featuredPagesCode, string $locale)
    {
        $response = $this->apiClient->fetchCmsContent($featuredPagesCode);

        Assert::eq($response, json_decode(file_get_contents(__DIR__ . '/../../ApiResponseMock/featured_pages.json'), true));

        $this->sharedStorage->set('featured_pages', $response);
    }

    /**
     * @Given One of the featured page is page :pageTitle
     */
    public function suluPageIsFeatured(string $pageTitle)
    {
        $featuredPages = $this->sharedStorage->get('featured_pages');

        foreach ($featuredPages['content']['links'] as $link) {
            if ($link['content']['title'] === $pageTitle) {
                return;
            }
        }

        throw  new \Exception('featured page not found');
    }

    /**
     * @Given Page :page has block :blockType
     */
    public function pageHasBlock(string $page, string $blockType)
    {
        $page = $this->sharedStorage->get($page);

        foreach ($page['content']['blocks'] as $block) {
            if ($block['type'] === $blockType) {
                return;
            }
        }

        throw  new \Exception('featured page not found');
    }

    /**
     * @Given Cache for sulu not exists
     */
    public function suluCacheNotExists()
    {
        if (is_dir($this->suluCacheDirectory)) {
            $this->removeDir($this->suluCacheDirectory);
        }
    }

    /**
     * @When :channel has enabled sulu localized requests
     */
    public function channelUseOrNotSuluLocalizedUrls(ChannelInterface $channel)
    {
        $channel->setSuluUseLocalizedUrls(true);

        $this->entityManager->flush();
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
}
