<?php


namespace App\Controller;

use App\Traits\ControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use League\Csv\Reader;

class DefaultController extends AbstractController
{
    use ControllerTrait;

    /**
     * @Route("/", name="index")
     */
    public function index(){
        return $this->render('index.html.twig',[]);
    }

    /**
     * For test purposes
     * @Route("/test", name="test")
     */
    public function test(){

    }
}