Feature: Marketing Automation integration

	Scenario: As a site maintainer, I get the Marketing Automation tracking code integrated by default
		When I go to the homepage
		Then I should see the marketing automation tracker code

	Scenario: As an editor, I expect to get Marketing Automation forms rendered on the site
		Given I have created a blog post "marketing_automation_test" with a marketing automation custom tag "abc"
		When I am on "marketing_automation_test"
		Then I expect to see the marketing automation form "abc" rendered
