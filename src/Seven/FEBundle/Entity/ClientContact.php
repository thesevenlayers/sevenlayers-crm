<?php
namespace Seven\FEBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Seven\FEBundle\Entity\Partial\BasicInfo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Seven\FEBundle\Repository\ClientContactRepository")
 * @ORM\Table(name="client_contacts")
 * @ORM\HasLifecycleCallbacks
 */
class ClientContact
{
    use BasicInfo;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="contacts")
     */
    protected $client;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Name is required")
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Email(message="Not a valid email")
     */
    protected $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $department;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $primary_contact;

    /**
     * Set client
     *
     * @param \Seven\FEBundle\Entity\Client $client
     * @return ClientContact
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
     * Set name
     *
     * @param string $name
     * @return ClientContact
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
     * Set email
     *
     * @param string $email
     * @return ClientContact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return ClientContact
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ClientContact
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set department
     *
     * @param string $department
     * @return ClientContact
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return string 
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set primary_contact
     *
     * @param boolean $primaryContact
     * @return ClientContact
     */
    public function setPrimaryContact($primaryContact)
    {
        $this->primary_contact = $primaryContact;

        return $this;
    }

    /**
     * Get primary_contact
     *
     * @return boolean
     */
    public function getPrimaryContact()
    {
        return $this->primary_contact;
    }
}
