<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceLineRepository")
 */
class InvoiceLine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $detail;

    /**
     * @ORM\Column(type="integer")
     */
    private $qty;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Please enter a price")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="LineUnit")
     */
    private $unit;


    /**
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="lines")
     */
    private $invoice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }


    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Compute total price for 1 single line
     * @return float|null
     */
    public function getTotalPrice():?float{
        return $this->qty * $this->price;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUnit(): ?LineUnit
    {
        return $this->unit;
    }

    public function setUnit(?LineUnit $unit): self
    {
        $this->unit = $unit;

        return $this;
    }
}
