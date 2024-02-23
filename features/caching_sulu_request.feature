@sulu_cache
Feature: Caching sulu page request
    In order to see again some page
    As a Visitor
    I want to be able to see the page without sending request to sulu

    Background:
        Given the store operates on a single channel in "United States"
        And Sulu has defined page "blog_page_with_blocks_and_links" in locale "en_US"
        And Cache for sulu not exists


    @ui
    Scenario: See the featured pages on homepage
        When I visit this channel's homepage
        And "United States" has enabled sulu localized requests
        Then Sulu cache should not exists
        And I visit a sulu page "blog_page_with_blocks_and_links" in locale en_US
        And Sulu cache should exists for "United States" with locale en_US

    @ui
    Scenario: Manually clear cache when localized urls are disabled
        When I visit a sulu page "blog_page_with_blocks_and_links" in locale en_US
        Then Sulu cache should exists
        And I am logged in as an administrator
        And I browse channels
        And I should see button "Purge sulu cache" in "United States"
        And I click "Clear Cache" button in "United States"
        And I should see success "Successfully purged" flash message
        And Sulu cache should exists for "United States" with locale en_US

    @ui
    Scenario: Manually clear cache when localized urls are enabled
        When "United States" has enabled sulu localized requests
        And I visit a sulu page "blog_page_with_blocks_and_links" in locale en_US
        Then Sulu cache should exists
        And I am logged in as an administrator
        And I browse channels
        And I should see expanded button "Purge sulu cache" in "United States"
        And I click expanded "en_US" button in "United States"
        And I should see success "Successfully purged" flash message
        And Sulu cache should exists for "United States" with locale en_US

    @ui
    Scenario: Manually clear cache when localized urls are disabled and cache not exists
        When I am logged in as an administrator
        And I browse channels
        Then I should see button "Purge sulu cache" in "United States"
        And I click "Purge sulu cache" button in "United States"
        And I should see error "Dir with sulu cache not found" flash message
