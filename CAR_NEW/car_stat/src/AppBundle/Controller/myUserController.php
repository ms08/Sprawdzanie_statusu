<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Session\Session;

class myUserController extends Controller
{

    /**
     * @Route("/user/login", name="userLogin")
     */
    public function loginUserAction(Request $request){
        $form = $this->createFormBuilder(array())
            ->add('kom',IntegerType::class)
            ->add('name',TextType::class)
            ->add('login',SubmitType::class,array('label'=>'Zaloguj'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $repository = $this->getDoctrine()->getRepository('AppBundle:Cars');

            $car = $repository->findOneBy(array('klient' => $data['name'], 'kom' => $data['kom']));
            if(empty($car)){
                return $this->render('AppBundle:myUser:login_user.html.twig',array('form' => $form->createView()));
            }
            else { //zaloguj
                $session = new Session();
                $session->set('userID',$car->getID());
                return $this->redirectToRoute('app_myuser_showonecar');
            }
        }

        return $this->render('AppBundle:myUser:login_user.html.twig',array('form' => $form->createView()));
    }
    /**
     * @Route("/user/showOneCar")
     */
    public function showOneCarAction()
    {
        return $this->render('AppBundle:myUser:show_one_car.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/user/showAllCars")
     */
    public function showAllCarsAction()
    {
        return $this->render('AppBundle:myUser:show_all_cars.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/user/main")
     */
    public function mainAction()
    {
        return $this->render('AppBundle:myUser:main.html.twig', array(
            // ...
        ));
    }

}
