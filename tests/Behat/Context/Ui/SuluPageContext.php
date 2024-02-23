<?php

declare(strict_types=1);

namespace Tests\BitBag\SyliusSuluPlugin\Behat\Context\Ui;

use Behat\Behat\Context\Context;
use Behat\Mink\Element\NodeElement;
use Symfony\Component\Validator\Constraints\When;
use Tests\BitBag\SyliusSuluPlugin\Behat\Page\HomePage;
use Tests\BitBag\SyliusSuluPlugin\Behat\Page\SuluPage;
use Webmozart\Assert\Assert;

final class SuluPageContext implements Context
{
    public function __construct(
        private HomePage $homePage,
        private SuluPage $suluPage,
    ) {
    }

    /**
     * @Then I should see :count featured pages.
     */
    public function suluHasPageInLocale(int $count)
    {
        $pages = $this->homePage->getFeaturedPages();

        Assert::count($pages, $count);
    }

    /**
     * @Then I should see featured page :pageTitle
     */
    public function iShouldSeeAFeaturedPage(string $pageTitle)
    {
        $pages = $this->homePage->getFeaturedPages();

        /** @var NodeElement $page */
        foreach ($pages as $page) {
            if ($page->find('css', 'span')?->getText() === $pageTitle) {
                return;
            }
        }

        throw new \Exception('Page not found');
    }

    /**
     * @When I visit a sulu page :pageSlug in locale :locale
     */
    public function iVisitSuluPage(string $pageSlug, string $locale)
    {
        $this->suluPage->open(['slug' => $pageSlug, 'locale' => $locale]);
    }

    /**
     * @Then I should see a :element with value :value
     */
    public function iShouldSeeElementWithValue(string $element, string $value)
    {
        /** @var NodeElement $nodeElement */
        $nodeElement = $this->suluPage->findElement($element);

        Assert::eq($nodeElement->getText(), $value);
    }

    /**
     * @Then I should see a block :element with value :value
     */
    public function iShouldSeeBlockElementWithValue(string $element, string $value)
    {
        /** @var NodeElement $nodeElement */
        $nodeElement = $this->suluPage->findBlockElement($element);

        Assert::eq($nodeElement->getText(), $value);
    }

    /**
     * @Then I should see a block image with url :url
     */
    public function iShouldSeeBlockImageWithUrl(string $url)
    {
        /** @var NodeElement $nodeElement */
        $nodeElement = $this->suluPage->findBlockElement('image');

        Assert::eq($nodeElement->find('css', 'img')->getAttribute('src'), $url);
    }
}
