<?php


namespace App\Services;

use App\Entity\Invoice;

/**
 * Class MyPDF overriding defaults TCPDF settings
 * @package App\Services
 */
class MyPDF extends \TCPDF
{
    /**
     * @var Invoice $invoice
     */
    protected $invoice = null;

    public function setInvoice(Invoice $invoice):self{
        $this->invoice = $invoice;
        return $this;
    }

    public function getInvoice():Invoice{
        return $this->invoice;
    }

    // Page footer
    public function Footer() {

        // Position at 15 mm from bottom
        $this->SetY(-30);

        // Set font
        $this->SetFont('helvetica', 'I', 8);

        $txt  = '';
        $txt .= "Ets. ". $this->invoice->getCompany()->getUser()->getFirstname();
        $txt .= " " . $this->invoice->getCompany()->getUser()->getLastname();
        $txt .= " - " . $this->invoice->getCompany()->getUser()->getEmail() . "\n";
        $txt .= "Dispensé d’immatriculation au Registre du Commerce et des Sociétés et au répertoire des métiers\n";
        $txt .= "Siège social : ";
        $txt .= $this->invoice->getCompany()->getFullAddress();
        $txt .= " – Entrepreneur Individuel";
        $txt .= " – SIREN : ".$this->invoice->getCompany()->getFormattedSiren()." – Code APE ".$this->invoice->getCompany()->getCodeNaf()."\n";
        $txt .= "-\n";
        $txt .= 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages() . "\n";


       $this->Multicell(0,10,$txt);


    }

}