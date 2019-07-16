<?php


namespace App\Controller;


use App\Entity\Invoice;
use App\Form\InvoiceFilterType;
use App\Form\InvoiceMultiLinesType;
use App\Form\InvoiceType;
use App\Repository\InvoiceRepository;
use App\Services\PdfFactory;
use App\Traits\ControllerTrait;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



/**
 * @Route("/invoice",name="invoice_")
 */
class InvoiceController extends AbstractController
{
    use ControllerTrait;

    /**
     * @Route("/list" , name="list")
     */
    public function list(Request $request){

        $form = $this->createForm(InvoiceFilterType::class);
        $form->handleRequest($request);

        /* @var InvoiceRepository $repo */
        $repo = $this->repository(Invoice::class);

        if($form->isSubmitted() && $form->isValid()){
           $invoices = $repo->findByFormFilter($form->getData());
        }else{
            $invoices = $repo->findBy([],['sent_at' => 'DESC']);
        }

        return $this->render('invoice/invoice_list.html.twig',[
            'invoices' => $invoices,
            'formFilter' => $form->createView(),
        ]);
    }

    /**
     * @Route("/add", name="add")
     * @param EntityManager $em
     * @param Request $request
     */
    public function add(EntityManagerInterface $em, Request $request){

        $form = $this->createForm(InvoiceType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            /** @var Invoice $invoice  */
            $invoice = $form->getData();
            $invoice->setCompany($this->getUser()->getCompany());
            $em->persist($invoice);
            $em->flush();

            $this->addFlash('success',$invoice->getReference() . ' created');
            return $this->redirectToRoute('invoice_list');
        }
        return $this->render('invoice/invoice_add.html.twig',['invoiceForm' => $form->createView()]);
    }

    /**
     * @ParamConverter("invoice", class="App\Entity\Invoice")
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Invoice $invoice){
        $this->remove($invoice);
        $this->flush();
        return $this->redirectToRoute('invoice_list');
    }

    /**
     * @ParamConverter("invoice", class="App\Entity\Invoice")
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Invoice $invoice, Request $request,EntityManagerInterface $em){
        $form = $this->createForm(InvoiceType::class,$invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em->persist($invoice);
            $em->flush();

            $this->addFlash('success',$invoice->getReference().  ' updated');
            return $this->redirectToRoute('invoice_list');
        }


        return $this->render('invoice/invoice_edit.html.twig',['invoiceForm' => $form->createView(),'invoice' => $invoice]);
    }

    /**
     * @ParamConverter("invoice", class="App\Entity\Invoice")
     * @Route("/print/{id}", name="print")
     */
    public function printPdf(Invoice $invoice, PdfFactory $pdf){
         $pdf->setInvoice($invoice);
         return new BinaryFileResponse($pdf->do());
    }

    /**
     * This function handle the invoice lines (adding line)
     * @ParamConverter("invoice", class="App\Entity\Invoice")
     * @Route("/{id}/lines", name="lines")
     */
    public function editLines(Invoice $invoice,Request $request,EntityManagerInterface $em){
        $form = $this->createForm(InvoiceMultiLinesType::class,$invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em->persist($invoice);
            $em->flush();
        }
        return $this->render('invoice/_form_edit_lines.html.twig',
                                ['form' => $form->createView(),'invoice' => $invoice]
        );
    }



}