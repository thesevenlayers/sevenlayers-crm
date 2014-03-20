<?php

namespace Seven\FEBundle\Controller;

use Seven\FEBundle\Entity\Client;
use Seven\FEBundle\Entity\ClientContact;
use Seven\FEBundle\Entity\Domain;
use Seven\FEBundle\Entity\EmailHost;
use Seven\FEBundle\Entity\Host;
use Seven\FEBundle\Entity\Maintenance;
use Seven\FEBundle\Entity\Miscellaneous;
use Seven\FEBundle\Entity\Utilities\Image;
use Seven\FEBundle\Entity\Utilities\ImageContainer;
use Seven\FEBundle\Form\ClientContactType;
use Seven\FEBundle\Form\ClientType;
use Seven\FEBundle\Form\DomainType;
use Seven\FEBundle\Form\EmailHostType;
use Seven\FEBundle\Form\HostType;
use Seven\FEBundle\Form\MaintenanceType;
use Seven\FEBundle\Form\MiscType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

class ClientController extends Controller
{
    public function indexAction()
    {
        $form = $this->createForm(new ClientType(), new Client());
        return $this->render('SevenFEBundle:Default/Client:clients.html.twig', array("form" => $form->createView()));
    }

    public function getClientsListPartialAction(Request $request)
    {
        $search_query = $request->query->get("query");
        $clients = $this->getDoctrine()->getRepository("SevenFEBundle:Client")->getClientsWithImages($search_query);
        return $this->render("SevenFEBundle:Default/Partial:clients_list.html.twig", array("clients" => $clients));
    }

    public function newAction(Request $request)
    {
        $name = $request->request->get("name_input");
        $address = $request->request->get("address_input");
        $file = $request->files->get("file", null);

        $em = $this->getDoctrine()->getManager();
        $client = new Client();

        if($file !== null)
        {
            $client->setImageContainer(new ImageContainer());

            $logo_entity = new Image();
            $client->setName($name);
            $client->setAddress($address);

            $logo_entity->setImageFile($file);
            $client->getImageContainer()->addImage($logo_entity);
        }
        $em->persist($client);
        $em->flush();

        return new JsonResponse(array("success" => true));
    }

    public function deleteAction(Client $client)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($client);
        $em->flush();
        return new JsonResponse(array("success" => true));

    }

    public function displayClientAction(Client $client)
    {
        $new_contact_form = $this->createForm(new ClientContactType(), new ClientContact());
        $new_domain_form = $this->createForm(new DomainType(), new Domain());
        $new_host_form = $this->createForm(new HostType(), new Host());
        $new_email_host_form = $this->createForm(new EmailHostType(), new EmailHost());
        $new_maintenance_form = $this->createForm(new MaintenanceType(), new Maintenance());
        $new_misc_form = $this->createForm(new MiscType(), new Miscellaneous());
        $service_providers = array();

        foreach($client->getProviderAccounts() as $accounts)
        {
            $service_providers[$accounts->getServiceProvider()->getId()] = $accounts->getServiceProvider()->getName();
        }

        return $this->render("SevenFEBundle:Default/Client:client_display.html.twig", array(
                "new_contact_form" => $new_contact_form->createView(),
                "new_domain_form" => $new_domain_form->createView(),
                "new_host_form" => $new_host_form->createView(),
                "new_email_host_form" => $new_email_host_form->createView(),
                "new_maintenance_form" => $new_maintenance_form->createView(),
                "new_misc_form" => $new_misc_form->createView(),
                "service_providers" => $service_providers,
                "client" => $client,
            ));
    }


    /******** Contact ***********/

    public function getClientContactPartialListAction(Request $request, $id)
    {
        $query = $request->query->get("q", null);
        $data_arr = array();
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('SevenFEBundle:Client')->find($id);
        $contacts = $em->getRepository("SevenFEBundle:ClientContact")->getContacts($client, $query);
        foreach($contacts as $contact)
        {
            $temp = array();
            $temp["contact"] = $contact;
            $temp["edit_form"] = $this->createForm(new ClientContactType(), $contact)->createView();
            $data_arr[] = $temp;
        }
        return $this->render("SevenFEBundle:Default/Partial:clients_contacts_list.html.twig", array(
                "client" => $client,
                "contacts" => $contacts,
                "data_arr" => $data_arr
            ));
    }

    public function postNewContactAction(Request $request, Client $client)
    {
       $result = $this->get("form.handler.basic")->handle($request, new ClientContactType(), new ClientContact());

        if($result instanceof JsonResponse) return $result;

        $client->addContact($result);

        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();
        return new JsonResponse(array("code" => 200));
    }

    public function postEditContactAction(Request $request, ClientContact $clientContact)
    {
        $result = $this->get("form.handler.basic")->handle($request, new ClientContactType(), $clientContact);

        if($result instanceof JsonResponse) return $result;

        $em = $this->getDoctrine()->getManager();
        $em->persist($result);
        $em->flush();
        return new JsonResponse(array("code" => 200));
    }

    public function postDeleteContactAction(ClientContact $contact)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();
        return new JsonResponse(array("success" => true));
    }

    public function postContactChangePrimaryAction(ClientContact $clientContact)
    {
        $em = $this->getDoctrine()->getManager();
        $clientContact->setPrimaryContact(!$clientContact->getPrimaryContact());
        $em->persist($clientContact);
        $em->flush();
        return new JsonResponse(array("success" => true));
    }


    /******** Domain ************/

    public function getClientDomainPartialListAction(Request $request, Client $client)
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
        $domains = $em->getRepository("SevenFEBundle:Domain")->getDomains($client, $query, $isp);
        foreach($domains as $domain)
        {
            $temp = array();
            $temp["domain"] = $domain;
            $temp["edit_form"] = $this->createForm(new DomainType(), $domain)->createView();
            $data_arr[] = $temp;
        }
        return $this->render("SevenFEBundle:Default/Partial:clients_domains_list.html.twig", array(
                "client" => $client,
                "domains" => $domains,
                "data_arr" => $data_arr
            ));
    }

    public function postNewDomainAction(Request $request, Client $client)
    {
        $result = $this->get("form.handler.basic")->handle($request, new DomainType(), new Domain());

        if($result instanceof JsonResponse) return $result;

        $client->addDomain($result);

        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();
        return new JsonResponse(array("code" => 200));
    }

    public function postEditDomainAction(Request $request, Domain $domain)
    {
        $result = $this->get("form.handler.basic")->handle($request, new DomainType(), $domain);

        if($result instanceof JsonResponse) return $result;

        $em = $this->getDoctrine()->getManager();
        $em->persist($result);
        $em->flush();
        return new JsonResponse(array("code" => 200));
    }

    public function postDeleteDomainAction(Domain $domain)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($domain);
        $em->flush();
        return new JsonResponse(array("success" => true));
    }

    public function postRenewDomainAction(Request $request, Domain $domain)
    {
        $new_price = $request->request->get("new_price");
        $extension_period = $request->request->get("extension_period", null);
        $new_price = empty($new_price) ? $domain->getPrice() : $new_price * $extension_period;

        if($extension_period != null)
        {
            $new_date = clone $domain->getEnd();
            $new_date->add(new \DateInterval("P{$extension_period}Y"));
            $domain->setEnd($new_date);
        }

        $domain->setPrice($new_price);

        $em = $this->getDoctrine()->getManager();
        $em->persist($domain);
        $em->flush();
        return new JsonResponse(array("success" => true));
    }

    /******** Host ************/

    public function getClientHostPartialListAction(Request $request, Client $client)
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
        $hosts = $em->getRepository("SevenFEBundle:Host")->getHosts($client, $query, $isp);
        foreach($hosts as $host)
        {
            $temp = array();
            $temp["host"] = $host;
            $temp["edit_form"] = $this->createForm(new HostType(), $host)->createView();
            $data_arr[] = $temp;
        }
        return $this->render("SevenFEBundle:Default/Partial:clients_hosts_list.html.twig", array(
                "client" => $client,
                "hosts" => $hosts,
                "data_arr" => $data_arr
            ));
    }

    public function postNewHostAction(Request $request, Client $client)
    {
        $result = $this->get("form.handler.basic")->handle($request, new HostType(), new Host());

        if($result instanceof JsonResponse) return $result;

        $client->addHost($result);

        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();
        return new JsonResponse(array("code" => 200));
    }

    public function postEditHostAction(Request $request, Host $host)
    {
        $result = $this->get("form.handler.basic")->handle($request, new HostType(), $host);

        if($result instanceof JsonResponse) return $result;

        $em = $this->getDoctrine()->getManager();
        $em->persist($result);
        $em->flush();
        return new JsonResponse(array("code" => 200));
    }

    public function postDeleteHostAction(Host $host)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($host);
        $em->flush();
        return new JsonResponse(array("success" => true));
    }

    public function postRenewHostAction(Request $request, Host $host)
    {
        $new_price = $request->request->get("new_price");
        $extension_period = $request->request->get("extension_period", null);
        $new_price = empty($new_price) ? $host->getPrice() : $new_price * $extension_period;

        if($extension_period != null)
        {
            $new_date = clone $host->getEnd();
            $new_date->add(new \DateInterval("P{$extension_period}Y"));
            $host->setEnd($new_date);
        }

        $host->setPrice($new_price);

        $em = $this->getDoctrine()->getManager();
        $em->persist($host);
        $em->flush();
        return new JsonResponse(array("success" => true));
    }

    /******** EmailHost ************/

    public function getClientEmailHostPartialListAction(Request $request, Client $client)
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
        $email_hosts = $em->getRepository("SevenFEBundle:EmailHost")->getEmailHosts($client, $query, $isp);
        foreach($email_hosts as $email_host)
        {
            $temp = array();
            $temp["email_host"] = $email_host;
            $temp["edit_form"] = $this->createForm(new EmailHostType(), $email_host)->createView();
            $data_arr[] = $temp;
        }
        return $this->render("SevenFEBundle:Default/Partial:clients_email_hosts_list.html.twig", array(
                "client" => $client,
                "email_hosts" => $email_hosts,
                "data_arr" => $data_arr
            ));
    }

    public function postNewEmailHostAction(Request $request, Client $client)
    {
        $result = $this->get("form.handler.basic")->handle($request, new EmailHostType(), new EmailHost());

        if($result instanceof JsonResponse) return $result;

        $client->addEmailHost($result);

        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();
        return new JsonResponse(array("code" => 200));
    }

    public function postEditEmailHostAction(Request $request, EmailHost $email_host)
    {
        $result = $this->get("form.handler.basic")->handle($request, new EmailHostType(), $email_host);

        if($result instanceof JsonResponse) return $result;

        $em = $this->getDoctrine()->getManager();
        $em->persist($result);
        $em->flush();
        return new JsonResponse(array("code" => 200));
    }

    public function postDeleteEmailHostAction(EmailHost $email_host)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($email_host);
        $em->flush();
        return new JsonResponse(array("success" => true));
    }

    public function postRenewEmailHostAction(Request $request, EmailHost $email_host)
    {
        $new_price = $request->request->get("new_price");
        $extension_period = $request->request->get("extension_period", null);
        $new_price = empty($new_price) ? $email_host->getPrice() : $new_price * $extension_period;

        if($extension_period != null)
        {
            $new_date = clone $email_host->getEnd();
            $new_date->add(new \DateInterval("P{$extension_period}Y"));
            $email_host->setEnd($new_date);
        }

        $email_host->setPrice($new_price);

        $em = $this->getDoctrine()->getManager();
        $em->persist($email_host);
        $em->flush();
        return new JsonResponse(array("success" => true));
    }

    /******** Maintenance ************/

    public function getClientMaintenancePartialListAction(Request $request, Client $client)
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
        $maintenances = $em->getRepository("SevenFEBundle:Maintenance")->getMaintenances($client, $query, $isp);
        foreach($maintenances as $maintenance)
        {
            $temp = array();
            $temp["maintenance"] = $maintenance;
            $temp["edit_form"] = $this->createForm(new MaintenanceType(), $maintenance)->createView();
            $data_arr[] = $temp;
        }
        return $this->render("SevenFEBundle:Default/Partial:clients_maintenances_list.html.twig", array(
                "client" => $client,
                "maintenances" => $maintenances,
                "data_arr" => $data_arr
            ));
    }

    public function postNewMaintenanceAction(Request $request, Client $client)
    {
        $result = $this->get("form.handler.basic")->handle($request, new MaintenanceType(), new Maintenance());

        if($result instanceof JsonResponse) return $result;

        $client->addMaintenance($result);

        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();
        return new JsonResponse(array("code" => 200));
    }

    public function postEditMaintenanceAction(Request $request, Maintenance $maintenance)
    {
        $result = $this->get("form.handler.basic")->handle($request, new MaintenanceType(), $maintenance);

        if($result instanceof JsonResponse) return $result;

        $em = $this->getDoctrine()->getManager();
        $em->persist($result);
        $em->flush();
        return new JsonResponse(array("code" => 200));
    }

    public function postDeleteMaintenanceAction(Maintenance $maintenance)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($maintenance);
        $em->flush();
        return new JsonResponse(array("success" => true));
    }

    public function postRenewMaintenanceAction(Request $request, Maintenance $maintenance)
    {
        $new_price = $request->request->get("new_price");
        $extension_period = $request->request->get("extension_period", null);
        $new_price = empty($new_price) ? $maintenance->getPrice() : $new_price * $extension_period;

        if($extension_period != null)
        {
            $new_date = clone $maintenance->getEnd();
            $new_date->add(new \DateInterval("P{$extension_period}Y"));
            $maintenance->setEnd($new_date);
        }

        $maintenance->setPrice($new_price);

        $em = $this->getDoctrine()->getManager();
        $em->persist($maintenance);
        $em->flush();
        return new JsonResponse(array("success" => true));
    }


    /******** Miscellaneous ************/

    public function getClientMiscPartialListAction(Request $request, Client $client)
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
        $miscs = $em->getRepository("SevenFEBundle:Miscellaneous")->getMisc($client, $query, $isp);
        foreach($miscs as $misc)
        {
            $temp = array();
            $temp["misc"] = $misc;
            $temp["edit_form"] = $this->createForm(new MiscType(), $misc)->createView();
            $data_arr[] = $temp;
        }
        return $this->render("SevenFEBundle:Default/Partial:clients_miscs_list.html.twig", array(
                "client" => $client,
                "miscs" => $miscs,
                "data_arr" => $data_arr
            ));
    }

    public function postNewMiscAction(Request $request, Client $client)
    {
        $result = $this->get("form.handler.basic")->handle($request, new MiscType(), new Miscellaneous());

        if($result instanceof JsonResponse) return $result;

        $client->addMiscellaneous($result);

        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();
        return new JsonResponse(array("code" => 200));
    }

    public function postEditMiscAction(Request $request, Miscellaneous $misc)
    {
        $result = $this->get("form.handler.basic")->handle($request, new MiscType(), $misc);

        if($result instanceof JsonResponse) return $result;

        $em = $this->getDoctrine()->getManager();
        $em->persist($result);
        $em->flush();
        return new JsonResponse(array("code" => 200));
    }

    public function postDeleteMiscAction(Miscellaneous $misc)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($misc);
        $em->flush();
        return new JsonResponse(array("success" => true));
    }

    public function postRenewMiscAction(Request $request, Miscellaneous $misc)
    {
        $new_price = $request->request->get("new_price");
        $extension_period = $request->request->get("extension_period", null);
        $new_price = empty($new_price) ? $misc->getPrice() : $new_price * $extension_period;

        if($extension_period != null)
        {
            $new_date = clone $misc->getEnd();
            $new_date->add(new \DateInterval("P{$extension_period}Y"));
            $misc->setEnd($new_date);
        }

        $misc->setPrice($new_price);

        $em = $this->getDoctrine()->getManager();
        $em->persist($misc);
        $em->flush();
        return new JsonResponse(array("success" => true));
    }

}
