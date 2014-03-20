<?php
namespace Seven\FEBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Seven\FEBundle\Entity\Partial\BasicInfo;
use Seven\FEBundle\Entity\Utilities\ImageContainer;

/**
 * @ORM\Entity(repositoryClass="Seven\FEBundle\Repository\ClientRepository")
 * @ORM\Table(name="clients")
 * @ORM\HasLifecycleCallbacks
 */
class Client
{
    use BasicInfo;

    /**
     * @ORM\OneToMany(targetEntity="ClientContact", mappedBy="client", cascade={"persist", "remove"})
     */
    protected $contacts;

    /**
     * @ORM\OneToMany(targetEntity="ProviderAccount", mappedBy="client", cascade={"remove"})
     */
    protected $provider_accounts;

    /**
     * @ORM\OneToMany(targetEntity="Domain", mappedBy="client", cascade={"persist", "remove"})
     */
    protected $domains;

    /**
     * @ORM\OneToMany(targetEntity="EmailHost", mappedBy="client", cascade={"persist", "remove"})
     */
    protected $email_hosts;

    /**
     * @ORM\OneToMany(targetEntity="Host", mappedBy="client", cascade={"persist", "remove"})
     */
    protected $hosts;

    /**
     * @ORM\OneToMany(targetEntity="Maintenance", mappedBy="client", cascade={"persist", "remove"})
     */
    protected $maintenance;

    /**
     * @ORM\OneToMany(targetEntity="Miscellaneous", mappedBy="client", cascade={"persist", "remove"})
     */
    protected $miscellaneous;


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
     * Constructor
     */
    public function __construct()
    {
        $this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->provider_accounts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->domains = new \Doctrine\Common\Collections\ArrayCollection();
        $this->email_hosts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->hosts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->maintenance = new \Doctrine\Common\Collections\ArrayCollection();
        $this->miscellaneous = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Client
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
     * @return Client
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
     * Add contacts
     *
     * @param \Seven\FEBundle\Entity\ClientContact $contacts
     * @return Client
     */
    public function addContact(\Seven\FEBundle\Entity\ClientContact $contacts)
    {
        $this->contacts[] = $contacts;
        $contacts->setClient($this);
        return $this;
    }

    /**
     * Remove contacts
     *
     * @param \Seven\FEBundle\Entity\ClientContact $contacts
     */
    public function removeContact(\Seven\FEBundle\Entity\ClientContact $contacts)
    {
        $this->contacts->removeElement($contacts);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Add provider_accounts
     *
     * @param \Seven\FEBundle\Entity\ProviderAccount $providerAccounts
     * @return Client
     */
    public function addProviderAccount(\Seven\FEBundle\Entity\ProviderAccount $providerAccounts)
    {
        $this->provider_accounts[] = $providerAccounts;

        return $this;
    }

    /**
     * Remove provider_accounts
     *
     * @param \Seven\FEBundle\Entity\ProviderAccount $providerAccounts
     */
    public function removeProviderAccount(\Seven\FEBundle\Entity\ProviderAccount $providerAccounts)
    {
        $this->provider_accounts->removeElement($providerAccounts);
    }

    /**
     * Get provider_accounts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProviderAccounts()
    {
        return $this->provider_accounts;
    }

    /**
     * Add domains
     *
     * @param \Seven\FEBundle\Entity\Domain $domains
     * @return Client
     */
    public function addDomain(\Seven\FEBundle\Entity\Domain $domains)
    {
        $this->domains[] = $domains;
        $domains->setClient($this);
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
     * @return Client
     */
    public function addEmailHost(\Seven\FEBundle\Entity\EmailHost $emailHosts)
    {
        $this->email_hosts[] = $emailHosts;
        $emailHosts->setClient($this);
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
     * @return Client
     */
    public function addHost(\Seven\FEBundle\Entity\Host $hosts)
    {
        $this->hosts[] = $hosts;
        $hosts->setClient($this);
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
     * @return Client
     */
    public function addMaintenance(\Seven\FEBundle\Entity\Maintenance $maintenance)
    {
        $this->maintenance[] = $maintenance;
        $maintenance->setClient($this);
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
     * Add miscellaneous
     *
     * @param \Seven\FEBundle\Entity\Miscellaneous $miscellaneous
     * @return Client
     */
    public function addMiscellaneous(\Seven\FEBundle\Entity\Miscellaneous $miscellaneous)
    {
        $this->miscellaneous[] = $miscellaneous;
        $miscellaneous->setClient($this);
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

    /**
     * Set image_container
     *
     * @param \Seven\FEBundle\Entity\Utilities\ImageContainer $imageContainer
     * @return Client
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
