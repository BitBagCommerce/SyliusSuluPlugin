@render_sulu_page
Feature: Render sulu page
    In order to see a sulu page
    As a Visitor
    I want to be able to see rendered sulu page

    Background:
        Given the store operates on a single channel in "United States"
        And Sulu has defined page "blog_page_with_properties" in locale "en_US"
        And Sulu has defined page "blog_page_with_blocks_and_links" in locale "en_US"
        And Page "blog_page_with_blocks_and_links" has block "quote"
        And Page "blog_page_with_blocks_and_links" has block "text"
        And Page "blog_page_with_blocks_and_links" has block "image"

    @ui
    Scenario: Rendering a sulu page with properties
        When I visit a sulu page "blog_page_with_properties" in locale en_US
        Then I should see a "title" with value "E-commerce trends"
        And I should see a "content" with value "CONTENT"

    @ui
    Scenario: Rendering a sulu page with properties and blocks
        When I visit a sulu page "blog_page_with_blocks_and_links" in locale en_US
        Then I should see a "title" with value "E-commerce trends"
        And I should see a block "content" with value "2021 was followed by the time of the 2020 pandemic. During these two years, a lot has changed..."
        And I should see a block image with url "https://en.wikipedia.org/wiki/Cat#/media/File:Sheba1.JPG"
        And I should see a block "quote" with value "Lorem ipsum dolor sit amet, con"
