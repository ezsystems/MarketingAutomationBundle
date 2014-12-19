<?php
/**
 * This file is part of the EzSystemsMarketingAutomationBundle package
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributd with this source code.
 */

namespace EzSystems\MarketingAutomationBundle\eZ\XmlText;

use DOMDocument;
use DOMXPath;
use eZ\Bundle\EzPublishLegacyBundle\DependencyInjection\Configuration\LegacyConfigResolver;
use eZ\Publish\Core\FieldType\XmlText\Converter as XmlTextConverter;

class PreConverterFactory
{
    protected $legacyConfigResolver;

    public function __construct( LegacyConfigResolver $legacyConfigResolver )
    {
        $this->legacyConfigResolver = $legacyConfigResolver;
    }

    public function build()
    {
        return new PreConverter(
            $this->legacyConfigResolver->getParameter('FormSettings.Hostname', 'ezma')
        );
    }
}
