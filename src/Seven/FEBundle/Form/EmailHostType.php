<?php
namespace Seven\FEBundle\Form;

use Seven\FEBundle\Form\Partial\BookingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmailHostType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add("booking", new BookingType(), array(
                    "data_class" => 'Seven\FEBundle\Entity\Domain'
                ))
            ->add("no_of_mailboxes", "text", array("required" => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                "data_class" => 'Seven\FEBundle\Entity\EmailHost',
            ));
    }

    public function getName()
    {
        return "email_host";
    }
}