<?php
namespace Seven\FEBundle\Form;

use Seven\FEBundle\DataTransformer\EndToHiddenTrans;
use Seven\FEBundle\DataTransformer\StartToHiddenTrans;
use Seven\FEBundle\Form\Partial\BookingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DomainType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add("booking", new BookingType(), array(
                    "data_class" => 'Seven\FEBundle\Entity\Domain'
                ));
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                "data_class" => 'Seven\FEBundle\Entity\Domain',
            ));
    }

    public function getName()
    {
        return "domain";
    }
}