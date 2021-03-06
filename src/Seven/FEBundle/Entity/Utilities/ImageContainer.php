<?php
namespace Seven\FEBundle\Entity\Utilities;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Seven\FEBundle\Entity\Partial\BasicInfo;

/**
 * @ORM\Entity
 * @ORM\Table(name="images_container")
 * @ORM\HasLifecycleCallbacks
 */
class ImageContainer
{
    use BasicInfo;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="container", cascade={"persist", "remove"})
     */
    protected $images;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add images
     *
     * @param \Seven\FEBundle\Entity\Utilities\Image $images
     * @return ImageContainer
     */
    public function addImage(\Seven\FEBundle\Entity\Utilities\Image $images)
    {
        $this->images[] = $images;
        $images->setContainer($this);
        return $this;
    }

    /**
     * Remove images
     *
     * @param \Seven\FEBundle\Entity\Utilities\Image $images
     */
    public function removeImage(\Seven\FEBundle\Entity\Utilities\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
}
