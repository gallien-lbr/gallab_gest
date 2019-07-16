<?php


namespace App\Traits;


trait ControllerTrait
{

    private function repository($class)
    {
        return $this->getDoctrine()->getManager()->getRepository($class);
    }


    private function flush($class = null)
    {
        $this->getDoctrine()->getManager()->flush($class);
    }

    private function remove($entity)
    {
        $this->getDoctrine()->getManager()->remove($entity);
    }

}