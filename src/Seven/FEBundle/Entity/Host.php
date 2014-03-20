<?php
namespace Seven\FEBundle\Entity;

use Seven\FEBundle\Entity\Partial\BookingInfo;
use Seven\FEBundle\Entity\Partial\ExpirationCheck;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Seven\FEBundle\Entity\Partial\BasicInfo;

/**
 * @ORM\Entity(repositoryClass="Seven\FEBundle\Repository\HostRepository")
 * @ORM\Table(name="hosts")
 * @ORM\HasLifecycleCallbacks
 */
class Host
{
    use BasicInfo;
    use ExpirationCheck;
    use BookingInfo;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="hosts")
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="ProviderAccount", inversedBy="hosts")
     * @Assert\NotBlank(message="provider is required")
     */
    protected $provider_account;


    /**
     * @ORM\OneToOne(targetEntity="FTP", cascade={"persist", "remove"})
     */
    protected $ftp;


    /**
     * @ORM\OneToOne(targetEntity="DB", cascade={"persist", "remove"})
     */
    protected $db;


    /**
     * @ORM\OneToOne(targetEntity="CPanel", cascade={"persist", "remove"})
     */
    protected $cpanel;


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
     * @return Domain
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
     * Set ftp
     *
     * @param \Seven\FEBundle\Entity\FTP $ftp
     * @return Host
     */
    public function setFtp(\Seven\FEBundle\Entity\FTP $ftp = null)
    {
        $this->ftp = $ftp;
        return $this;
    }

    /**
     * Get ftp
     *
     * @return \Seven\FEBundle\Entity\FTP 
     */
    public function getFtp()
    {
        return $this->ftp;
    }

    /**
     * Set db
     *
     * @param \Seven\FEBundle\Entity\DB $db
     * @return Host
     */
    public function setDb(\Seven\FEBundle\Entity\DB $db = null)
    {
        $this->db = $db;

        return $this;
    }

    /**
     * Get db
     *
     * @return \Seven\FEBundle\Entity\DB 
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * Set cpanel
     *
     * @param \Seven\FEBundle\Entity\CPanel $cpanel
     * @return Host
     */
    public function setCpanel(\Seven\FEBundle\Entity\CPanel $cpanel = null)
    {
        $this->cpanel = $cpanel;

        return $this;
    }

    /**
     * Get cpanel
     *
     * @return \Seven\FEBundle\Entity\CPanel 
     */
    public function getCpanel()
    {
        return $this->cpanel;
    }
}
