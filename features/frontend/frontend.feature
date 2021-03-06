@frontend
Feature: Call for papers
    As an user
    I should be able to participate in conference
    In order to be a conference speaker

Background:
    Given following "Event":
        | ref    | title     | description                | startDate        | endDate          | venue              | email               | host                      |
        | event  | My event  | My another awesome event!  | 2016-03-01 10:00 | 2016-03-01 18:00 | Burj Khalifa Tower | eventator@email.com | http://localhost:8000     |
        | event  | My event  | My another awesome event!  | 2016-03-01 10:00 | 2016-03-01 18:00 | Burj Khalifa Tower | eventator@email.com | http://eventator.loc:8080 |
    And following "EventTranslation":
        | ref    | locale |
        | event  | ru_RU  |

Scenario: Viewing the homepage at website root
    Given I am on "/"
    And I should see "My event"

@javascript
Scenario: User should able call for papers
    Given I am on "/"
    When I click "Call for Paper"
    Then I wait for a form
    And I fill in "Name" with "Alex Demchenko"
    And I fill in "Email" with "email@example.com"
    And I fill in "Title" with "Another awesome speech"
    And I select "Russian" from "Language"
    And I select "Experts" from "Talk level"
    And I fill in "Abstract of your talk" with "symfony propagation"
    And I fill in "Notes" with "symfony propagation"
    When I press "Send"
    Then I wait for a form
    Then I should see "Thank you for request, we'll answer back asap."
