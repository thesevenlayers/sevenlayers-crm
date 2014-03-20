<?php
namespace Seven\FEBundle\Entity\Partial;

trait ExpirationCheck
{
    public function daysBeforeExpiration()
    {
//        $interval = (new \DateTime()) - ($this->end->format("U"));
//        return $interval->format("j");
        return ceil(($this->end->format("U") - time()) / 86400);

    }

    public function IsNearExpiration()
    {
        if($this->daysBeforeExpiration() <= 7)
        {
            return true;
        } else {
            return false;
        }
    }

    public function IsExpired()
    {
        if($this->daysBeforeExpiration() <= 0)
        {
            return true;
        } else {
            return false;
        }
    }
}