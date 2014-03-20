<?php
namespace Seven\FEBundle\Entity;

use Seven\FEBundle\Entity\Partial\BookingInfo;
use Seven\FEBundle\Entity\Partial\ExpirationCheck;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Seven\FEBundle\Entity\Partial\BasicInfo;

/**
 * @ORM\Entity(repositoryClass="Seven\FEBundle\Repository\MaintenanceRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="maintenances")
 */
class Maintenance
{
    use BasicInfo;
    use BookingInfo;
    use ExpirationCheck;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="maintenance")
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="ProviderAccount", inversedBy="maintenances")
     */
    protected $provider_account;

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
     * Set provider_account
     *
     * @param \Seven\FEBundle\Entity\ProviderAccount $providerAccount
     * @return Maintenance
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
