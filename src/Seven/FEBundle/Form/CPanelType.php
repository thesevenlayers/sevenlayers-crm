<?php
namespace Seven\FEBundle\Form;

use Seven\FEBundle\Form\Partial\CredentialType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CPanelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add("credential", new CredentialType(), array(
                    "data_class" => 'Seven\FEBundle\Entity\CPanel'
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                "data_class" => 'Seven\FEBundle\Entity\CPanel',
            ));
    }

    public function getName()
    {
        return "cpanel";
    }
}