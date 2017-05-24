<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Form\FormBuilder;

class AdminController extends Controller
{
    /**
     * @Route("/admin/addTable")
     */
    public function addTableAction(Request $request)
    {

        $data = [];
        $form = $this -> createFormBuilder($data)
            ->add('file',FileType::class,array('label'=>'Plik'))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            return new Response('ok');
        }

        return $this->render('AppBundle:Admin:add_table.html.twig', array(
           'form'=>$form->createView()
        ));
    }

    /**
     * @Route("/admin/deleteTable")
     */
    public function deleteTableAction()
    {

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('DEL p FROM AppBundle:Product p WHERE');

        return $this->render('AppBundle:Admin:delete_table.html.twig', array(
            // ...
        ));

    }

}
