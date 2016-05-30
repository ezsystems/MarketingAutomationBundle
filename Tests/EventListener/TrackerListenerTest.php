<?php
/**
 * This file is part of the EzSystemsMarketingAutomationBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\MarketingAutomationBundle\Tests\EventListener;

use EzSystems\MarketingAutomationBundle\EventListener\TrackerListener;
use PHPUnit_Framework_TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class TrackerListenerTest extends PHPUnit_Framework_TestCase
{
    const INSTALLATION_ID = __CLASS__;

    /** @var \EzSystems\MarketingAutomationBundle\EventListener\TrackerListener $listener */
    private $listener;

    public function setUp()
    {
        $this->listener = new TrackerListener(true, self::INSTALLATION_ID);
    }

    public function testOnKernelResponse()
    {
        $response = new Response('<html><body></body></html>');
        $e = $this->createFilterResponseEvent($response);
        $this->listener->onKernelResponse($e);

        self::assertContains(
            sprintf('data-pid="%s"', self::INSTALLATION_ID),
            $response->getContent()
        );
    }

    public function testOnKernelResponseNoBodyTag()
    {
        $response = new Response('<div>');
        $e = $this->createFilterResponseEvent($response);
        $this->listener->onKernelResponse($e);

        self::assertNotContains(
            sprintf('data-pid="%s"', self::INSTALLATION_ID),
            $response->getContent()
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param int $requestType HttpKernelInterface::MASTER_REQUEST or HttpKernelInterface::SUB_REQUEST
     *
     * @return \Symfony\Component\HttpKernel\Event\FilterResponseEvent
     */
    protected function createFilterResponseEvent($response, $requestType = HttpKernelInterface::MASTER_REQUEST)
    {
        return new FilterResponseEvent(
            $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface'),
            new Request(),
            $requestType,
            $response
        );
    }
}
