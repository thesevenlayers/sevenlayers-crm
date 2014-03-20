<?php
namespace Seven\FEBundle\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StartToHiddenTrans implements DataTransformerInterface
{
    public function transform($date)
    {
        if($date == null)
        {
            return "";
        }

        return $date->format("m/d/Y");
    }


    public function reverseTransform($value)
    {
        if($value == null)
        {
            return null;
        }

        $start = \DateTime::createFromFormat("m/d/Y", $value);
        return $start;
    }
}