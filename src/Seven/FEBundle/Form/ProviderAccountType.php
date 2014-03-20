<?php
namespace Seven\FEBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProviderAccountType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add("client", "entity", array(
                    "error_bubbling" => true,
                    "empty_value" => "Client",
                    "class" => 'Seven\FEBundle\Entity\Client',
                    "property" => "name",
                ))
            ->add("service_provider", "entity", array(
                    "error_bubbling" => true,
                    "empty_value" => "Service Provider",
                    "class" => 'Seven\FEBundle\Entity\ServiceProvider',
                    "property" => "name"
                ))
            ->add("name", "text", array("error_bubbling" => true))
            ->add("username", "text", array("required" => false))
            ->add("password", "password", array("required" => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                "data_class" => 'Seven\FEBundle\Entity\ProviderAccount',
            ));
    }

    public function getName()
    {
        return "provider_account";
    }
}