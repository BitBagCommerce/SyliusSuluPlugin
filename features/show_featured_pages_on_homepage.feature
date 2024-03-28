@sulu_page
Feature: Show featured pages on homepage
    In order to see featured pages on homepage
    As a Visitor
    I want to be able to see featured pages on homepage

    Background:
        Given the store operates on a single channel in "United States"
        And Sulu has defined featured pages list featured_pages in locale en_US
        And One of the featured page is page "Blog Page 1"
        And One of the featured page is page "Blog Page 2"
        And One of the featured page is page "Blog Page 3"

    @ui
    Scenario: See the featured pages on homepage
        When I visit this channel's homepage
        Then I should see 3 featured pages.
        And I should see featured page "Modern design trends in Europe"
        And I should see featured page "Blog Page 2"
        And I should see featured page "Shoe sizes tables of the World"
