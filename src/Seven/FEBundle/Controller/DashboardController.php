<?php

namespace Seven\FEBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine();
        $clients = $em->getRepository("SevenFEBundle:Client")->findAll();
        $service_providers = $em->getRepository("SevenFEBundle:ServiceProvider")->findAll();

        return $this->render('SevenFEBundle:Default:index.html.twig', array(
                "clients" => $clients,
                "service_providers" => $service_providers
            ));
    }
}
