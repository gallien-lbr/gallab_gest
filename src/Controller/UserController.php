<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user",name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @param Request $request
     * @Route("/edit" , name="edit")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request)
    {
        $form = $this->createForm(UserType::class,    $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            //$em->persist();
            //$em->flush();

            //$this->addFlash('success','Customer '.$customer->getName().' updated');
            //return $this->redirectToRoute('customer_list');
        }


        return $this->render('user/edit.html.twig',['form' => $form->createView()]);


    }

}
