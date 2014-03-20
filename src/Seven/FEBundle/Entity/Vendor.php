<?php
namespace Seven\FEBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Seven\FEBundle\Entity\Partial\BasicInfo;

/**
 * @ORM\Entity
 * @ORM\Table(name="vendors")
 */
class Vendor
{
    use BasicInfo;

    /**
     * @ORM\ManyToMany(targetEntity="Client")
     */
    protected $clients;

    /**
     * @ORM\OneToMany(targetEntity="Domain", mappedBy="vendor")
     */
    protected $domains;

    /**
     * @ORM\OneToMany(targetEntity="EmailHost", mappedBy="vendor")
     */
    protected $email_hosts;

    /**
     * @ORM\OneToMany(targetEntity="Host", mappedBy="vendor")
     */
    protected $hosts;

    /**
     * @ORM\OneToMany(targetEntity="Maintenance", mappedBy="vendor")
     */
    protected $maintenance;

    /**
     * @ORM\OneToMany(targetEntity="Miscellaneous", mappedBy="vendor")
     */
    protected $miscellaneous;


    /**
     * @ORM\OneToOne(targetEntity="Seven\FEBundle\Entity\Utilities\ImageContainer")
     */
    protected $image_container;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $name;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clients = new \Doctrine\Common\Collections\ArrayCollection();
        $this->domains = new \Doctrine\Common\Collections\ArrayCollection();
        $this->email_hosts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->hosts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->maintenance = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Vendor
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
     * Add clients
     *
     * @param \Seven\FEBundle\Entity\Client $clients
     * @return Vendor
     */
    public function addClient(\Seven\FEBundle\Entity\Client $clients)
    {
        $this->clients[] = $clients;

        return $this;
    }

    /**
     * Remove clients
     *
     * @param \Seven\FEBundle\Entity\Client $clients
     */
    public function removeClient(\Seven\FEBundle\Entity\Client $clients)
    {
        $this->clients->removeElement($clients);
    }

    /**
     * Get clients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * Add domains
     *
     * @param \Seven\FEBundle\Entity\Domain $domains
     * @return Vendor
     */
    public function addDomain(\Seven\FEBundle\Entity\Domain $domains)
    {
        $this->domains[] = $domains;

        return $this;
    }

    /**
     * Remove domains
     *
     * @param \Seven\FEBundle\Entity\Domain $domains
     */
    public function removeDomain(\Seven\FEBundle\Entity\Domain $domains)
    {
        $this->domains->removeElement($domains);
    }

    /**
     * Get domains
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDomains()
    {
        return $this->domains;
    }

    /**
     * Add email_hosts
     *
     * @param \Seven\FEBundle\Entity\EmailHost $emailHosts
     * @return Vendor
     */
    public function addEmailHost(\Seven\FEBundle\Entity\EmailHost $emailHosts)
    {
        $this->email_hosts[] = $emailHosts;

        return $this;
    }

    /**
     * Remove email_hosts
     *
     * @param \Seven\FEBundle\Entity\EmailHost $emailHosts
     */
    public function removeEmailHost(\Seven\FEBundle\Entity\EmailHost $emailHosts)
    {
        $this->email_hosts->removeElement($emailHosts);
    }

    /**
     * Get email_hosts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmailHosts()
    {
        return $this->email_hosts;
    }

    /**
     * Add hosts
     *
     * @param \Seven\FEBundle\Entity\Host $hosts
     * @return Vendor
     */
    public function addHost(\Seven\FEBundle\Entity\Host $hosts)
    {
        $this->hosts[] = $hosts;

        return $this;
    }

    /**
     * Remove hosts
     *
     * @param \Seven\FEBundle\Entity\Host $hosts
     */
    public function removeHost(\Seven\FEBundle\Entity\Host $hosts)
    {
        $this->hosts->removeElement($hosts);
    }

    /**
     * Get hosts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHosts()
    {
        return $this->hosts;
    }

    /**
     * Add maintenance
     *
     * @param \Seven\FEBundle\Entity\Maintenance $maintenance
     * @return Vendor
     */
    public function addMaintenance(\Seven\FEBundle\Entity\Maintenance $maintenance)
    {
        $this->maintenance[] = $maintenance;

        return $this;
    }

    /**
     * Remove maintenance
     *
     * @param \Seven\FEBundle\Entity\Maintenance $maintenance
     */
    public function removeMaintenance(\Seven\FEBundle\Entity\Maintenance $maintenance)
    {
        $this->maintenance->removeElement($maintenance);
    }

    /**
     * Get maintenance
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMaintenance()
    {
        return $this->maintenance;
    }

    /**
     * Set image_container
     *
     * @param \Seven\FEBundle\Entity\Utilities\ImageContainer $imageContainer
     * @return Vendor
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

    /**
     * Add miscellaneous
     *
     * @param \Seven\FEBundle\Entity\Miscellaneous $miscellaneous
     * @return Vendor
     */
    public function addMiscellaneous(\Seven\FEBundle\Entity\Miscellaneous $miscellaneous)
    {
        $this->miscellaneous[] = $miscellaneous;

        return $this;
    }

    /**
     * Remove miscellaneous
     *
     * @param \Seven\FEBundle\Entity\Miscellaneous $miscellaneous
     */
    public function removeMiscellaneous(\Seven\FEBundle\Entity\Miscellaneous $miscellaneous)
    {
        $this->miscellaneous->removeElement($miscellaneous);
    }

    /**
     * Get miscellaneous
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMiscellaneous()
    {
        return $this->miscellaneous;
    }
}
