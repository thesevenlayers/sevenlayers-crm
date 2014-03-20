<?php

namespace Seven\FEBundle\Controller;

use Seven\FEBundle\Entity\ProviderAccount;
use Seven\FEBundle\Form\ProviderAccountType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ProviderAccountController extends Controller
{
    public function indexAction()
    {
        $form = $this->createForm(new ProviderAccountType(), new ProviderAccount());
        $provider_accounts = $this->getDoctrine()->getRepository("SevenFEBundle:ProviderAccount")->findAll();
        $service_providers = array();
        foreach($provider_accounts as $account)
        {
            $service_providers[$account->getServiceProvider()->getId()] = $account->getServiceProvider()->getName();
        }

        return $this->render('SevenFEBundle:Default/ProviderAccount:index.html.twig', array(
                "new_provider_account_form" => $form->createView(),
                "service_providers" => $service_providers
            ));
    }

    public function getProviderAccountPartialListAction(Request $request)
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
        $provider_accounts = $em->getRepository("SevenFEBundle:ProviderAccount")->getProviderAccounts($query, $isp);
        foreach($provider_accounts as $provider_account)
        {
            $temp = array();
            $temp["provider_account"] = $provider_account;
            $temp["edit_form"] = $this->createForm(new ProviderAccountType(), $provider_account)->createView();
            $data_arr[] = $temp;
        }
        return $this->render("SevenFEBundle:Default/Partial:provider_accounts_list.html.twig", array(
                "provider_accounts" => $provider_accounts,
                "data_arr" => $data_arr
            ));
    }

    public function postNewProviderAccountAction(Request $request)
    {
        $result = $this->get("form.handler.basic")->handle($request, new ProviderAccountType(), new ProviderAccount());

        if($result instanceof JsonResponse) return $result;

        $em = $this->getDoctrine()->getManager();
        $em->persist($result);
        $em->flush();
        return new JsonResponse(array("code" => 200));
    }

    public function postEditProviderAccountAction(Request $request, ProviderAccount $provider_account)
    {
        $result = $this->get("form.handler.basic")->handle($request, new ProviderAccountType(), $provider_account);

        if($result instanceof JsonResponse) return $result;

        $em = $this->getDoctrine()->getManager();
        $em->persist($result);
        $em->flush();
        return new JsonResponse(array("code" => 200));
    }


    public function deleteAction(ProviderAccount $provider_account)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($provider_account);
        $em->flush();
        return new JsonResponse(array("success" => true));

    }

}
