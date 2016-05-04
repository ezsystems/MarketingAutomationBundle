<?php
/**
 * This file is part of the EzSystemsMarketingAutomationBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\MarketingAutomationBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Listens for the Kernel Response Event, and adds, if applicable, the Marketing Automation tracker before the closing
 * body HTML tag.
 */
class TrackerListener implements EventSubscriberInterface
{
    /** @var string */
    private $installationId;

    /** @var bool */
    private $isEnabled;

    /**
     * @param bool $isEnabled
     * @param string $installationId Marketing Automation installation ID
     */
    public function __construct($isEnabled, $installationId)
    {
        $this->installationId = $installationId;
        $this->isEnabled = $isEnabled;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => array('onKernelResponse'),
        );
    }

    public function onKernelResponse(FilterResponseEvent $e)
    {
        if (!$this->isEnabled && $e->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
            return;
        }

        if (stripos($e->getResponse()->getContent(), '</body>') === false) {
            return;
        }

        $scriptCode = <<<EOT
<script id="__maSrc" type="text/javascript" data-pid="{$this->installationId}">
(function () {
    var d=document,t='script',c=d.createElement(t),s=(d.URL.indexOf('https:')==0?'s':''),p;
    c.type = 'text/java'+t;
    c.src = 'http'+s+'://'+s+'c.cdnma.com/apps/capture.js';
    p=d.getElementsByTagName(t)[0];p.parentNode.insertBefore(c,p);
}());
</script>
EOT;
        $e->getResponse()->setContent(
            str_ireplace('</body>', $scriptCode . '</body>', $e->getResponse()->getContent())
        );
    }
}
