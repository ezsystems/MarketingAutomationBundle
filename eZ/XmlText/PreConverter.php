<?php
/**
 * This file is part of the EzSystemsMarketingAutomationBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributd with this source code.
 */
namespace EzSystems\MarketingAutomationBundle\eZ\XmlText;

use DOMDocument;
use DOMXPath;
use eZ\Publish\Core\FieldType\XmlText\Converter as XmlTextConverter;

/**
 * Injects the configured Marketing Automation hostname into the ezmaform custom tag.
 */
class PreConverter implements XmlTextConverter
{
    protected $hostName;

    public function __construct($hostName)
    {
        $this->hostName = $hostName;
    }

    public function setHostName($hostName)
    {
        $this->hostName = $hostName;
    }

    public function convert(DOMDocument $xmlDoc)
    {
        $xpath = new DOMXPath($xmlDoc);
        /** @var \DOMElement $customNode */
        foreach ($xpath->query("//custom[@name='ezmaform']") as $customNode) {
            $customNode->setAttribute('custom:hostname', $this->hostName);
        }

        return null;
    }
}
