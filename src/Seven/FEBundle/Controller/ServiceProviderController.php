<?php

namespace Seven\FEBundle\Controller;

use Seven\FEBundle\Entity\ServiceProvider;
use Seven\FEBundle\Entity\Utilities\Image;
use Seven\FEBundle\Entity\Utilities\ImageContainer;
use Seven\FEBundle\Form\ServiceProviderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ServiceProviderController extends Controller
{
    public function indexAction()
    {
        $form = $this->createForm(new ServiceProviderType(), new ServiceProvider());
        return $this->render('SevenFEBundle:Default/ServiceProvider:index.html.twig', array("form" => $form->createView()));
    }

    public function getServiceProviderPartialListAction(Request $request)
    {
        $query = $request->query->get("q", null);
        $ignore_sp = $request->query->get("isp", null);
        $isp = null;
        if(!is_null($ignore_sp))
        {
            $arr = array();
            parse_str($ignore_sp, $arr);
            $isp = $arr["isp"];
        }

        $data_arr = array();
        $em = $this->getDoctrine()->getManager();
        $service_providers = $em->getRepository("SevenFEBundle:ServiceProvider")->getServiceProviders($query, $isp);
        foreach($service_providers as $service_provider)
        {
            $temp = array();
            $temp["service_provider"] = $service_provider;
            $temp["edit_form"] = $this->createForm(new ServiceProviderType(), $service_provider)->createView();
            $data_arr[] = $temp;
        }
        return $this->render("SevenFEBundle:Default/Partial:service_providers_content_list.html.twig", array(
                "service_providers" => $service_providers,
                "data_arr" => $data_arr
            ));
    }

    public function newAction(Request $request)
    {
        $name = $request->request->get("name_input", null);
        $address = $request->request->get("address_input");
        $file = $request->files->get("file", null);

        $em = $this->getDoctrine()->getManager();
        $service_provider = new ServiceProvider();

        if($name == null)
        {
            return new JsonResponse(array("success" => false));
        }

        if($file !== null)
        {
            $service_provider->setImageContainer(new ImageContainer());

            $logo_entity = new Image();
            $service_provider->setName($name);
            $service_provider->setAddress($address);

            $logo_entity->setImageFile($file);
            $service_provider->getImageContainer()->addImage($logo_entity);
        }
        $em->persist($service_provider);
        $em->flush();

        return new JsonResponse(array("success" => true));
    }

    public function postEditContactAction(Request $request, ServiceProvider $serviceProvider)
    {
//        $result = $this->get("form.handler.basic")->handle($request, new ServiceProviderType(), $serviceProvider);

//        if($result instanceof JsonResponse) return $result;

        $name = $request->request->get("name_input");
        $address = $request->request->get("address_input");
        $file = $request->files->get("file", null);

        if($file !== null)
        {
            $serviceProvider->setImageContainer(new ImageContainer());

            $logo_entity = new Image();
            $serviceProvider->setName($name);
            $serviceProvider->setAddress($address);

            $logo_entity->setImageFile($file);
            $serviceProvider->getImageContainer()->addImage($logo_entity);
        }
        $serviceProvider->setName($name);
        $serviceProvider->setAddress($address);
        $em = $this->getDoctrine()->getManager();
        $em->persist($serviceProvider);
        $em->flush();
        return new JsonResponse(array("success" => true));
    }

    public function deleteAction(ServiceProvider $serviceProvider)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($serviceProvider);
        $em->flush();
        return new JsonResponse(array("success" => true));

    }

}
