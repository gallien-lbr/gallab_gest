<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 * @UniqueEntity(
 *     fields={"reference"},
 *     message="The invoice reference you entered already exists"
 * )
 */
class Invoice
{
    public function __construct()
    {
        $this->created_at = new \DateTime('NOW');
        $this->lines = new ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Please enter a reference")
     */
    private $reference;

    /**
     * @ORM\Column(type="date")
     */
    private $created_at;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $paid_at;

    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $sent_at;


    /**
     * @ORM\ManyToOne(targetEntity="Customer",inversedBy="invoices",fetch="EAGER" )
     * @ORM\JoinColumn(nullable=true)
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity="PaymentMethod",fetch="EAGER")
     * @ORM\JoinColumn(name="payment_id", referencedColumnName="id", nullable=true)
     */
    private $paymentMethod;


    /**
     * @ORM\ManyToOne(targetEntity="InvoiceCategory", fetch="EAGER")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descr;

    /**
     * @ORM\ManyToOne(targetEntity="Company",inversedBy="invoices")
     */
    private $company;

    /**
     * Cascade the deletion of lines and persisted when lines added
     * @ORM\OneToMany(targetEntity="InvoiceLine", mappedBy="invoice", cascade={"persist","remove"})
     */
    private $lines;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $secretNotes;

    /**
     * @ORM\Column(type="integer",nullable=false)
     */
    private $paymentMaxDuration = 30;


    /**
     * @ORM\Column(type="boolean")
     */
    private $generatePdf = true;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPaidAt(): ?\DateTimeInterface
    {
        return $this->paid_at;
    }

    public function setPaidAt(?\DateTimeInterface $paid_at): self
    {
        $this->paid_at = $paid_at;

        return $this;
    }



    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?PaymentMethod $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }



    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getCategory(): ?InvoiceCategory
    {
        return $this->category;
    }

    public function setCategory(?InvoiceCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getDescr(): ?string
    {
        return $this->descr;
    }

    public function setDescr(string $descr): self
    {
        $this->descr = $descr;

        return $this;
    }


    public function removeLine(InvoiceLine $line): self
    {
        if ($this->lines->contains($line)) {
            $this->lines->removeElement($line);
            // set the owning side to null (unless already changed)
            if ($line->getInvoice() === $this) {
                $line->setInvoice(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|InvoiceLine[]
     */
    public function getLines(): Collection
    {
        return $this->lines;
    }

    public function addLine(InvoiceLine $line): self
    {
        if (!$this->lines->contains($line)) {
            $this->lines[] = $line;
            $line->setInvoice($this);
        }

        return $this;
    }


    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sent_at;
    }

    public function setSentAt(?\DateTimeInterface $sent_at): self
    {
        $this->sent_at = $sent_at;

        return $this;
    }

    /**
     * Computes total invoice price
     * @return float|null
     */
    public function getTotalPrice():?float {
        $total = 0;
        foreach ($this->getLines() as $line){
            $total += $line->getTotalPrice();
        }
        return $total;
    }

    public function getGeneratePdf(): ?bool
    {
        return $this->generatePdf;
    }

    public function setGeneratePdf(bool $generatePdf): self
    {
        $this->generatePdf = $generatePdf;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Computes the invoice due Date as displayed in invoice
     * By default is sent_at + 30 days
     * @param int $number
     * @return false|string
     */
    public function getDueDate():?string {
        if ($this->sent_at){

            return date('d-m-Y',strtotime($this->sent_at->format('d-m-Y'). ' + ' .$this->paymentMaxDuration. ' days')) ;
        }
        return null;
    }

    public function getSecretNotes(): ?string
    {
        return $this->secretNotes;
    }

    public function setSecretNotes(?string $secretNotes): self
    {
        $this->secretNotes = $secretNotes;

        return $this;
    }

    public function getPaymentMaxDuration(): ?int
    {
        return $this->paymentMaxDuration;
    }

    public function setPaymentMaxDuration(?int $paymentMaxDuration): self
    {
        $this->paymentMaxDuration = $paymentMaxDuration;

        return $this;
    }


}
