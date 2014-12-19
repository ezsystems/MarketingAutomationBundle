<?php
/**
 * This file is part of the EzSystemsMarketingAutomationBundle package
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributd with this source code.
 */
namespace EzSystems\MarketingAutomationBundle\DependencyInjection\Factory;

use eZ\Bundle\EzPublishLegacyBundle\DependencyInjection\Configuration\LegacyConfigResolver;
use EzSystems\MarketingAutomationBundle\EventListener\TrackerListener;

/**
 * Factory for services that depend on a legacy configuration variable
 */
class LegacyConfigurationAwareFactory
{
    /** @var \eZ\Bundle\EzPublishLegacyBundle\DependencyInjection\Configuration\LegacyConfigResolver $legacyConfigResolver */
    protected $legacyConfigResolver;

    /**
     * @param \eZ\Bundle\EzPublishLegacyBundle\DependencyInjection\Configuration\LegacyConfigResolver $legacyConfigResolver
     */
    public function __construct( LegacyConfigResolver $legacyConfigResolver )
    {
        $this->legacyConfigResolver = $legacyConfigResolver;
    }

    /**
     * @return \EzSystems\MarketingAutomationBundle\EventListener\TrackerListener
     */
    public function buildTrackerListener()
    {
        return new TrackerListener(
            $this->legacyConfigResolver->getParameter( 'TrackingSettings.InstallationId', 'ezma' )
        );
    }
}
