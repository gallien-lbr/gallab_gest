<?php


namespace App\Controller;


use App\Entity\Customer;
use App\Form\CustomerType;
use App\Traits\ControllerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/customer" , name="customer_")
 */
class CustomerController extends AbstractController
{
    use ControllerTrait;


    /**
     * @Route("/list" , name="list")
     */
    public function list(){
        $repo = $this->repository(Customer::class);
        $customers = $repo->findAll();

        return $this->render('customer/customer_list.html.twig',
                                   [ 'customers' => $customers  ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request, EntityManagerInterface $em){
        $form = $this->createForm(CustomerType::class);
        $form->handleRequest($request);
        $repo = $this->repository(Customer::class);
        $customers = $repo->findAll();

        if ($form->isSubmitted() && $form->isValid()){
            /** @var Customer $customer  */
            $customer = $form->getData();
            $em->persist($customer);
            $em->flush();
            $this->addFlash('success','Customer '.$customer->getName().' created');
            return $this->redirectToRoute('customer_list');
        }

        return $this->render('customer/customer_add.html.twig',
            [ 'customers' => $customers , 'customerForm' => $form->createView() ]);
    }

    /**
     * @ParamConverter("customer", class="App\Entity\Customer")
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Customer $customer,Request $request,  EntityManagerInterface $em){
        $repo = $this->repository(Customer::class);
        $customers = $repo->findAll();
        $form = $this->createForm(CustomerType::class,$customer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $em->persist($customer);
            $em->flush();

            $this->addFlash('success','Customer '.$customer->getName().' updated');
            return $this->redirectToRoute('customer_list');
        }


        return $this->render('customer/customer_list.html.twig',['customerForm' => $form->createView(),'customers'=>$customers]);
    }

    /**
     * @ParamConverter("customer", class="App\Entity\Customer")
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Customer $customer){

        $this->remove($customer);
        $this->flush();
        $this->addFlash('success','Customer '.$customer->getName().' deleted');
        return $this->redirectToRoute('customer_list');
    }
}