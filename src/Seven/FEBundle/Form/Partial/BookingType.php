<?php
namespace Seven\FEBundle\Form\Partial;

use Seven\FEBundle\DataTransformer\EndToHiddenTrans;
use Seven\FEBundle\DataTransformer\StartToHiddenTrans;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookingType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $startTrans = new StartToHiddenTrans();
        $endTrans = new EndToHiddenTrans();

        $builder
            ->add("address", "text", array("error_bubbling" => true))
            ->add("description", "textarea", array("required" => false))
            ->add("notes", "textarea", array("required" => false))
            ->add("provider_account", "entity", array(
                    "error_bubbling" => true,
                    "empty_value" => "Provider Account",
                    "class" => 'Seven\FEBundle\Entity\ProviderAccount',
                    "property" => "name"
                ))
            ->add("price", "text", array("error_bubbling" => true))
            ->add($builder->create("start", "date", array(
                        "error_bubbling" => true,
                        "years" => range((new \DateTime())->format("Y"),(new \DateTime("+10 years"))->format("Y"))
                ))
            )
            ->add($builder->create("end", "date", array(
                        "error_bubbling" => true,
                        "years" => range((new \DateTime())->format("Y"),(new \DateTime("+10 years"))->format("Y"))
                ))
            )
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
        return "booking";
    }
}