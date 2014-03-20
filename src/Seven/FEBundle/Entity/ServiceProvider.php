<?php
namespace Seven\FEBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Seven\FEBundle\Entity\Partial\BasicInfo;

/**
 * @ORM\Entity(repositoryClass="Seven\FEBundle\Repository\ServiceProviderRepository")
 * @ORM\Table(name="service_providers")
 * @ORM\HasLifecycleCallbacks
 */
class ServiceProvider
{
    use BasicInfo;

    /**
     * @ORM\OneToOne(targetEntity="Seven\FEBundle\Entity\Utilities\ImageContainer", cascade={"persist", "remove"})
     */
    protected $image_container;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $address;


    /**
     * Set name
     *
     * @param string $name
     * @return ServiceProvider
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return ServiceProvider
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set image_container
     *
     * @param \Seven\FEBundle\Entity\Utilities\ImageContainer $imageContainer
     * @return ServiceProvider
     */
    public function setImageContainer(\Seven\FEBundle\Entity\Utilities\ImageContainer $imageContainer = null)
    {
        $this->image_container = $imageContainer;
        return $this;
    }

    /**
     * Get image_container
     *
     * @return \Seven\FEBundle\Entity\Utilities\ImageContainer 
     */
    public function getImageContainer()
    {
        return $this->image_container;
    }
}
