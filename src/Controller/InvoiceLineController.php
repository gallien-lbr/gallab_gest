<?php

namespace App\Controller;

use App\Entity\InvoiceLine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/invoice_line",name="invoice_line_")
 */
class InvoiceLineController extends AbstractController
{

    /**
     * @ParamConverter("line", class="App\Entity\InvoiceLine")
     * @Route("/remove/{id}", name="remove", methods={"GET"})
     */
    public function removeLine(InvoiceLine $line,
                               EntityManagerInterface $em
    )
    {
        $em->remove($line);
        $em->flush();
        return $this->redirectToRoute('invoice_lines',
               ['id'=>$line->getInvoice()->getId()]);
    }
}