<?php
namespace Seven\FEBundle\Services;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class BasicFormHandler
{
    protected $builder;
    public function __construct(FormFactoryInterface $FI)
    {
        $this->builder = $FI;
    }

    public function handle($request, $type, $entity)
    {
        $form = $this->builder->create($type, $entity);
        $form->handleRequest($request);
        if(!$form->isValid()){
            $error_arr = array();
            foreach($form->getErrors() as $error)
            {
                $error_arr[] = $error->getMessageTemplate();
            }
            return new JsonResponse(
                array(
                    "code" => 403,
                    "message" => $error_arr
                ));
        }
        else
        {
            return $entity;
        }

    }

}