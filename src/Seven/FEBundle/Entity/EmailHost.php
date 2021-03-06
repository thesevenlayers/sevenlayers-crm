<?php
namespace Seven\FEBundle\Entity;

use Seven\FEBundle\Entity\Partial\BookingInfo;
use Seven\FEBundle\Entity\Partial\ExpirationCheck;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Seven\FEBundle\Entity\Partial\BasicInfo;

/**
 * @ORM\Entity(repositoryClass="Seven\FEBundle\Repository\EmailHostRepository")
 * @ORM\Table(name="email_hosts")
 * @ORM\HasLifecycleCallbacks
 */
class EmailHost
{
    use BasicInfo;
    use BookingInfo;
    use ExpirationCheck;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="emails")
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="ProviderAccount", inversedBy="email_hosts")
     */
    protected $provider_account;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $no_of_mailboxes;

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
     * @return EmailHost
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

    /**
     * Set no_of_mailboxes
     *
     * @param string $noOfMailboxes
     * @return EmailHost
     */
    public function setNoOfMailboxes($noOfMailboxes)
    {
        $this->no_of_mailboxes = $noOfMailboxes;

        return $this;
    }

    /**
     * Get no_of_mailboxes
     *
     * @return string 
     */
    public function getNoOfMailboxes()
    {
        return $this->no_of_mailboxes;
    }
}
