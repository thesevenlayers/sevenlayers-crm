<?php
namespace Seven\FEBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ServiceProviderType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add("name", "text")
            ->add("address", "text", array("required" => false))
//            ->add("logo", "file", array("mapped" => false, "required" => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                "data_class" => 'Seven\FEBundle\Entity\ServiceProvider',
            ));
    }

    public function getName()
    {
        return "service_provider";
    }
}