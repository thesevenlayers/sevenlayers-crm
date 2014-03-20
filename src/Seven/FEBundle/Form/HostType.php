<?php
namespace Seven\FEBundle\Form;

use Seven\FEBundle\DataTransformer\EndToHiddenTrans;
use Seven\FEBundle\DataTransformer\StartToHiddenTrans;
use Seven\FEBundle\Form\Partial\BookingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HostType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add("booking", new BookingType(), array(
                    "data_class" => 'Seven\FEBundle\Entity\Host'
                ))
            ->add("ftp", new FTPType())
            ->add("db", new DBType())
            ->add("cpanel", new CPanelType())
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                "data_class" => 'Seven\FEBundle\Entity\Host',
                "cascade_validation" => true,
            ));
    }

    public function getName()
    {
        return "host";
    }
}