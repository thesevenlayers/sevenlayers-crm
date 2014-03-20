<?php
namespace Seven\FEBundle\Entity;

use Seven\FEBundle\Entity\Partial\BookingInfo;
use Seven\FEBundle\Entity\Partial\ExpirationCheck;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Seven\FEBundle\Entity\Partial\BasicInfo;

/**
 * @ORM\Entity(repositoryClass="Seven\FEBundle\Repository\MiscRepository")
 * @ORM\Table(name="miscellaneous")
 * @ORM\HasLifecycleCallbacks
 */
class Miscellaneous
{
    use BasicInfo;
    use BookingInfo;
    use ExpirationCheck;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="maintenance")
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="ProviderAccount", inversedBy="miscellaneouses")
     */
    protected $provider_account;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $username;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $password;

    /**
     * Set client
     *
     * @param \Seven\FEBundle\Entity\Client $client
     * @return Domain
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
     * Set username
     *
     * @param string $username
     * @return Miscellaneous
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
     * @return Miscellaneous
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
     * Set provider_account
     *
     * @param \Seven\FEBundle\Entity\ProviderAccount $providerAccount
     * @return Miscellaneous
     */
    public function setProviderAccount(\Seven\FEBundle\Entity\ProviderAccount $providerAccount = null)
    {
        $this->provider_account = $providerAccount;

        return $this;
    }

    /**
     * Get provider_account
     *
     * @return \Seven\FEBundle\Entity\ProviderAccount 
     */
    public function getProviderAccount()
    {
        return $this->provider_account;
    }
}
