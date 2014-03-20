<?php

namespace Seven\FEBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PartialController extends Controller
{
    public function getPartialServiceProviderListAction($sp = null)
    {
        return $this->render("SevenFEBundle:Default/Partial:service_providers_list.html.twig", array(
                "service_providers" => $sp
            ));

    }
}
