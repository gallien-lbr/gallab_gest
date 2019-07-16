<?php

namespace App\Services;
use App\Entity\Invoice;
use Twig\Environment;

/**
 *
 * Class PdfFactory
 * @package App\Services
 */
class PdfFactory
{
    protected $pdf;
    protected $fname;

    protected $invoice;
    protected $twig;

    public function __construct(Environment $twig)
    {
        setlocale (LC_TIME, 'fr_FR.utf8','fra');

        $this->twig = $twig;

        $this->pdf = new MyPDF(
            PDF_PAGE_ORIENTATION,
            PDF_UNIT,
            PDF_PAGE_FORMAT,
            true,
            'UTF-8',
            false);
    }

    public function setInvoice(Invoice $invoice) {
        $this->pdf->setInvoice($invoice);
    }


    public function do()
    {
        // set document information
                $this->pdf->SetCreator('Facturizator');
                $this->pdf->SetAuthor('Ets ' . $this->pdf->getInvoice()->getCompany()->getUser()->getFullname());
                $this->pdf->SetTitle($this->pdf->getInvoice()->getReference());
                $this->pdf->SetSubject('Facture [subject_field)');
                $this->pdf->SetKeywords('Facture, PDF');


        $ts = $this->pdf->getInvoice()->getSentAt()->getTimestamp();

        $this->pdf->SetHeaderData(null, null,

            'Référence de la facture : ' . $this->pdf->getInvoice()->getReference(),
            'Émise le : ' . strftime('%d %B %Y',$ts),
            // couleurs
            array(0, 0, 0), array(0, 0, 0));

        $this->pdf->setFooterData(array(0, 0, 0), array(0, 0, 0));

        // set header and footer fonts
        $this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $this->pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set default font subsetting mode
       $this->pdf->setFontSubsetting(true);

        // ---------------------------------------------------------

        // set font
        $this->pdf->SetFont('helvetica', '', 10);
                //$this->pdf->SetFont('dejavusans', '', 10, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
                $this->pdf->AddPage();


        // Set some content to print
         $html = $this->render_template();

        $this->pdf->setCellPaddings( $left = '', $top = '', $right = '', $bottom = '');

        // Print text using writeHTMLCell()
        $this->pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);



        // ---------------------------------------------------------
        // Page 2 with banking information
        $this->pdf->AddPage('P', 'A4');


        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
         $this->pdf->Output('facture_'.$this->pdf->getInvoice()->getReference().'.pdf', 'I');
    }

    /**
     * @return string|null
     */
    private function render_template():?string
    {
        return $this->twig->render('invoice/invoice_pdf.html.twig',['invoice'=>$this->pdf->getInvoice()]);
    }

}