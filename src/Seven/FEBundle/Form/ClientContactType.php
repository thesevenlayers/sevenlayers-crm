<?php
namespace Seven\FEBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientContactType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add("name", "text", array("error_bubbling" => true))
            ->add("email", "email", array("error_bubbling" => true))
            ->add("phone", "text", array("required" => false))
            ->add("title", "text", array("required" => false))
            ->add("department", "text", array("required" => false))
            ->add("primary_contact", "checkbox", array("required" => false));
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                "data_class" => 'Seven\FEBundle\Entity\ClientContact',
            ));
    }

    public function getName()
    {
        return "client_contact";
    }
}