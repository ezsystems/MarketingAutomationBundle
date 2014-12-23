<?php
/**
 * File containing the Context class for Demo.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 */

namespace EzSystems\MarketingAutomationBundle\Features;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Mink\Element\DocumentElement;
use eZ\Publish\Core\Repository\Repository;
use EzSystems\DemoBundle\Features\Context\Demo;
use EzSystems\BehatBundle\Helper\EzAssertion;
use Behat\Behat\Context\Step;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as Assertion;

/**
 * Base context for Demo content assertion
 */
class Context extends Demo
{
    /**
     * @Given /^I have created a blog post "([^"]*)" with a marketing automation custom tag "([^"]*)"$/
     */
    public function iHaveCreatedABlogPostWithAMarketingAutomationCustomTag( $pageIdentifier, $maFormIdentifier )
    {
        $kernel = $this->getKernel();
        /** @var \eZ\Publish\Core\Repository\Repository $repository */
        $container = $kernel->getContainer();
        $repository = $container->get('ezpublish.api.repository');

        $contentService = $container->get('ezpublish.api.service.content');
        $contentTypeService = $container->get('ezpublish.api.service.content_type');
        $locationService = $container->get('ezpublish.api.service.location');
        $createStruct = $contentService->newContentCreateStruct(
            $contentTypeService->loadContentTypeByIdentifier('blog_post'),
            'eng-GB'
        );
        $body = <<< XML
<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"
         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"
         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/">
<paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">
    <custom name="ezmaform" custom:form_id="$maFormIdentifier"/></paragraph>
</section>
XML;

        $createStruct->setField('title', $pageIdentifier);
        $createStruct->setField('body', $body);

        $locationCreateStruct = $locationService->newLocationCreateStruct(2);

        $content = $repository->sudo(
            function ( Repository $repository ) use ( $createStruct, $locationCreateStruct )
            {
                return $repository->getContentService()->publishVersion(
                    $repository->getContentService()->createContent( $createStruct,
                        [$locationCreateStruct]
                    )->versionInfo
                );
            }
        );

        $urlAliasService = $container->get('ezpublish.api.service.url_alias');
        $locationAliases = $urlAliasService->listLocationAliases(
            $locationService->loadLocation($content->contentInfo->mainLocationId),
            false
        );
        $this->pageIdentifierMap[$pageIdentifier] = $locationAliases[0]->path;
    }

    /**
     * @Then /^I expect to see the marketing automation form "([^"]*)" rendered$/
     */
    public function iExpectToSeeTheMarketingAutomationFormRendered( $maFormIdentifier )
    {
        $elements = $this->getSession()->getPage()->findAll("css", "div#MAform-$maFormIdentifier");
        Assertion::assertCount( 1, $elements );
    }

    /**
     * @Then /^I should see the marketing automation tracker code$/
     */
    public function iShouldSeeTheMarketingAutomationTrackerCode()
    {
        $elements = $this->getSession()->getPage()->findAll("css", "script#__maSrc");
        Assertion::assertCount( 1, $elements );
    }
}
