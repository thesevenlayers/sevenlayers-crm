<?php
namespace Seven\FEBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Seven\FEBundle\Entity\Partial\BasicInfo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Seven\FEBundle\Repository\ProviderAccountRepository")
 * @ORM\Table(name="provider_accounts")
 * @ORM\HasLifecycleCallbacks
 */
class ProviderAccount
{
    use BasicInfo;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="provider_accounts")
     * @Assert\NotBlank(message="client is required")
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="ServiceProvider")
     * @Assert\NotBlank(message="provider is required")
     */
    protected $service_provider;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="name is required")
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $username;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $password;

    /**
     * Set name
     *
     * @param string $name
     * @return ProviderAccount
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
     * Set username
     *
     * @param string $username
     * @return ProviderAccount
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return ProviderAccount
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set client
     *
     * @param \Seven\FEBundle\Entity\Client $client
     * @return ProviderAccount
     */
    public function setClient(\Seven\FEBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \Seven\FEBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set service_provider
     *
     * @param \Seven\FEBundle\Entity\ServiceProvider $serviceProvider
     * @return ProviderAccount
     */
    public function setServiceProvider(\Seven\FEBundle\Entity\ServiceProvider $serviceProvider = null)
    {
        $this->service_provider = $serviceProvider;

        return $this;
    }

    /**
     * Get service_provider
     *
     * @return \Seven\FEBundle\Entity\ServiceProvider 
     */
    public function getServiceProvider()
    {
        return $this->service_provider;
    }
}
