<?php
namespace Seven\FEBundle\Entity\Partial;

trait BookingInfo
{
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="address is required")
     */
    protected $address;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="start is required")
     */
    protected $start;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="end is required")
     */
    protected $end;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $notes;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="price is required")
     */
    protected $price;


    /**
     * Set address
     *
     * @param string $address
     * @return Domain
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
     * Set start
     *
     * @param \DateTime $start
     * @return Domain
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return Domain
     */
    public function setEnd($end)
    {
        $this->end = $end;
        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }


    /**
     * Set notes
     *
     * @param string $notes
     * @return Domain
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Domain
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Domain
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }
}