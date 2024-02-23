<?php

namespace Tests\BitBag\SyliusSuluPlugin\Behat\Context\Ui;

use Behat\Behat\Context\Context;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\Helper\JavaScriptTestHelperInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Tests\BitBag\SyliusSuluPlugin\Behat\Page\ChannelIndexPage;
use Webmozart\Assert\Assert;

final class SuluAdminPanelContext implements Context
{
    public function __construct(
        private ChannelIndexPage $channelIndexPage,
        private string $suluCacheDirectory,
        private NotificationCheckerInterface $notificationChecker,
        private JavaScriptTestHelperInterface $testHelper,
    ) {
    }

    /**
     * @Then Sulu cache should not exists
     */
    public function suluCacheShouldNotExists()
    {
        return !is_dir($this->suluCacheDirectory);
    }

    /**
     * @Then Sulu cache should exists
     */
    public function suluCacheShouldExists()
    {
        return is_dir($this->suluCacheDirectory);
    }

    /**
     * @Then Sulu cache should exists for :channel with locale :locale
     */
    public function suluCacheShouldExistsForChannelWithLocale(ChannelInterface $channel, string $locale)
    {
        return is_dir(sprintf('%s/%s/%s', $this->suluCacheDirectory, $channel->getCode(), $locale));
    }

    /**
     * @Then I should see button :button in :channel
     */
    public function iShouldSeeAButtonInChannelRow(string $buttonText, ChannelInterface $channel)
    {
        $button = $this->channelIndexPage->findAPurgeCacheButton();

        Assert::eq($button->getText(), $buttonText);
    }

    /**
     * @Then I click :button button in :channel
     */
    public function iClickAButtonInChannelRow(string $button, ChannelInterface $channel)
    {
        $button = $this->channelIndexPage->findAPurgeCacheButton();

        $button->click();
    }

    /**
     * @Then I should see :type :message flash message
     */
    public function iShouldSeeAFlashMessage(string $type, string $message)
    {
        $type = match ($type) {
            'error' => NotificationType::failure(),
            'success' => NotificationType::success()
        };

        $this->testHelper->waitUntilNotificationPopups(
            $this->notificationChecker,
            $type,
            $message,
        );
    }

    /**
     * @Then I should see expanded button :button in :channel
     */
    public function iShouldSeeACollapsedButtonInChannelRow(string $buttonText, ChannelInterface $channel)
    {
        $button = $this->channelIndexPage->findAPurgeCacheButtonWithLocales();

        Assert::eq($button->find('css', 'span.text')->getText(), $buttonText);
    }

    /**
     * @Then I click expanded :text button in :channel
     */
    public function iClickAButtonCollapsedInChannelRow(string $text, ChannelInterface $channel)
    {
        $button = $this->channelIndexPage->findAPurgeCacheButtonWithLocales();

        $button = $button->find('css', 'a.item');

        Assert::eq($button->getText(), $text);

        $button->click();
    }

}
