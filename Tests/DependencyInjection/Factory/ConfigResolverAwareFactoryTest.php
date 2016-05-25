<?php
/**
 * This file is part of the EzSystemsMarketingAutomationBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\MarketingAutomationBundle\Tests\DependencyInjection\Factory;

use EzSystems\MarketingAutomationBundle\DependencyInjection\Factory\ConfigResolverAwareFactory;
use PHPUnit_Framework_TestCase;

class ConfigResolverAwareFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var \eZ\Publish\Core\MVC\ConfigResolverInterface|\PHPUnit_Framework_MockObject_MockObject $legacyConfigResolver */
    private $configResolver;

    /** @var \EzSystems\MarketingAutomationBundle\DependencyInjection\Factory\LegacyConfigurationAwareFactory $factory */
    private $factory;

    public function setUp()
    {
        $this->configResolver = $this->getMock('eZ\Publish\Core\MVC\ConfigResolverInterface');
        $this->factory = new ConfigResolverAwareFactory($this->configResolver);
    }

    public function testBuildTrackerListener()
    {
        self::assertInstanceOf(
            'EzSystems\MarketingAutomationBundle\EventListener\TrackerListener',
            $this->factory->buildTrackerListener()
        );
    }
}
