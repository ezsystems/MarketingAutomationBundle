<?php
/**
 * This file is part of the EzSystemsMarketingAutomationBundle package
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\MarketingAutomationBundle\DependencyInjection\Factory;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use EzSystems\MarketingAutomationBundle\EventListener\TrackerListener;

/**
 * Factory for services that depend on a legacy configuration variable
 */
class ConfigResolverAwareFactory
{
    /** @var \eZ\Publish\Core\MVC\ConfigResolverInterface $configResolver */
    protected $configResolver;

    /**
     * @param \eZ\Publish\Core\MVC\ConfigResolverInterface $configResolver
     */
    public function __construct( ConfigResolverInterface $configResolver )
    {
        $this->configResolver = $configResolver;
    }

    /**
     * @return \EzSystems\MarketingAutomationBundle\EventListener\TrackerListener
     */
    public function buildTrackerListener()
    {
        return new TrackerListener(
            $this->configResolver->getParameter( 'TrackingSettings.InstallationId', 'ezma' )
        );
    }
}
