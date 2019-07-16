<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompanyRepository")
 */
class Company
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;



    /**
     * @ORM\ManyToOne(targetEntity="Country")
     */
    private $country;

    /**
     * Store "Country + area + number separately"
     * @ORM\Column(type="string", length=20)
     */
    private $phone;


    /**
     * @ORM\OneToMany(targetEntity="Invoice",mappedBy="company")
     */
    private $invoices;

    /**
     * @ORM\Column(type="bigint")
     */
    private $siret;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $codeNaf;

    /**
     * @ORM\OneToMany(targetEntity="Customer", mappedBy="company")
     */
    private $customers;

    /**
     * @ORM\OneToOne(targetEntity="User",mappedBy="company")
     */
    private $user;



    public function __construct()
    {
        $this->invoices = new ArrayCollection();
        $this->customers = new ArrayCollection();
    }




    /**
     * @fixme
     * @return float|null
     */
    public function getGrossSales(): ?float
    {
        $res = null;
        foreach ($this->invoices as $i => $invoice) {
            $res += $invoice->getTotalPrice();
        }
        return $res;
    }

    public function getSiret(): ?int
    {
        return $this->siret;
    }

    /**
     * Get SIREN code based on SIRET
     * @return bool|string
     */
    public function getSiren():?string{
        return substr($this->siret,0,9);
    }

    /**
     * Get NIC code based on SIRET
     * @return bool|string
     */
    public function getNic():?string {
        return substr($this->siret,9,5);
    }


    /**
     * Return a SIRET number for display, including spaces : 012 345 456 7890
     * @return string|null
     */
    public function getFormattedSiret():?string {

        $res = $this->getFormattedSiren();
        $res .= ' ' . $this->getNic();

        return $res;
    }

    /**
     * Return a SIREN number for display
     * @return string|null
     */
    public function getFormattedSiren():?string{
        return chunk_split($this->getSiren(),3,' ');
    }


    public function getFullAddress(){
        $res = $this->getAddress1() .' '  ?? '';
        $res .= $this->getAddress2() .' ' ?? '';
        $res .= $this->getPostalCode(). ' ' ?? '';
        $res .= $this->getCity();
        return $res;
    }


    public function setSiret(int $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * By default phones are stored with the international code
     * we may want to display it as national number without country code (+ xx)
     * @return string|null
     */
    public function getNationalPhone():?string{
        return  chunk_split('0'.substr($this->phone,3,10), 2, ' ');
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

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

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->setCompany($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->contains($customer)) {
            $this->customers->removeElement($customer);
            // set the owning side to null (unless already changed)
            if ($customer->getCompany() === $this) {
                $customer->setCompany(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newCompany = $user === null ? null : $this;
        if ($newCompany !== $user->getCompany()) {
            $user->setCompany($newCompany);
        }

        return $this;
    }

    /**
     * @return Collection|Invoice[]
     */
        public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setCompany($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->contains($invoice)) {
            $this->invoices->removeElement($invoice);
            // set the owning side to null (unless already changed)
            if ($invoice->getCompany() === $this) {
                $invoice->setCompany(null);
            }
        }

        return $this;
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(?string $address1): self
    {
        $this->address1 = $address1;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(?string $address2): self
    {
        $this->address2 = $address2;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }



    public function getCodeNaf(): ?string
    {
        return $this->codeNaf;
    }

    public function setCodeNaf(string $codeNaf): self
    {
        $this->codeNaf = $codeNaf;

        return $this;
    }



}
