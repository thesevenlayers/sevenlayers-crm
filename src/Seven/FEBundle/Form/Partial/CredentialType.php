<?php
namespace Seven\FEBundle\Form\Partial;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CredentialType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add("url", "text", array("required" => false))
            ->add("username", "text", array("required" => false))
            ->add("password", "password", array("required" => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                "inherit_data" => true
            ));
    }

    public function getName()
    {
        return "credential";
    }
}