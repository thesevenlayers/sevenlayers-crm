<?php
namespace Seven\FEBundle\Form;

use Seven\FEBundle\Form\Partial\BookingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MiscType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add("booking", new BookingType(), array(
                    "data_class" => 'Seven\FEBundle\Entity\Miscellaneous'
                ))
            ->add("username", "text", array("required" => false))
            ->add("password", "password", array("required" => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                "data_class" => 'Seven\FEBundle\Entity\Miscellaneous',
            ));
    }

    public function getName()
    {
        return "miscellaneous";
    }
}