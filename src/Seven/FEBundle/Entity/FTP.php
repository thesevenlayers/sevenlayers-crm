<?php
namespace Seven\FEBundle\Entity;

use Seven\FEBundle\Entity\Partial\BasicInfo;
use Seven\FEBundle\Entity\Partial\HelpersInfo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ftps")
 * @ORM\HasLifecycleCallbacks
 */
class FTP
{
    use BasicInfo;
    use HelpersInfo;

}
