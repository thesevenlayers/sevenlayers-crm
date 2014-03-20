<?php
namespace Seven\FEBundle\Entity;

use Seven\FEBundle\Entity\Partial\BasicInfo;
use Seven\FEBundle\Entity\Partial\HelpersInfo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cpanels")
 * @ORM\HasLifecycleCallbacks
 */
class CPanel
{
    use BasicInfo;
    use HelpersInfo;

}
