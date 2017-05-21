<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin/addTable")
     */
    public function addTableAction()
    {
        return $this->render('AppBundle:Admin:add_table.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/admin/deleteTable")
     */
    public function deleteTableAction()
    {
        return $this->render('AppBundle:Admin:delete_table.html.twig', array(
            // ...
        ));

        
    }

}
