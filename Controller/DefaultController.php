<?php

namespace EzSystems\MarketingAutomationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('EzSystemsMarketingAutomationBundle:Default:index.html.twig', array('name' => $name));
    }
}
