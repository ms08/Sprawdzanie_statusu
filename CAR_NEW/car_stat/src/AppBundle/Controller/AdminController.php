<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Session\Session;

use AppBundle\Entity\Cars;
use AppBundle\Entity\UsersAdmin;

class AdminController extends Controller
{
    /**
     * @param FormInterface $form
     * @return UploadedFile
     */
    private function getFile(FormInterface $form)
    {
        return $file = $form->getData()['file'];
    }

    private function validateFile(UploadedFile $file)
    {
        if ($file->getClientOriginalExtension() !== "csv") {
            throw new InvalidArgumentException("File should has extension CSV");
        };

        if ($file->guessExtension() !== "txt") {
            throw new InvalidArgumentException("File should has textual content");
        };
    }

    private function processFile(UploadedFile $file)
    {
        $content = file_get_contents($file->getRealPath());

        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder(';', '"', '\\', '""')]);
        $data = $serializer->decode($content, 'csv');

        $em = $this->getDoctrine()->getManager();


        $connection = $em->getConnection();
        $connection->beginTransaction();

        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $connection->query('DELETE FROM cars');

            foreach ($data as $array) {
                $object = new Cars();
                $object->setKom($array['Kom.']);
                $object->setRm($array['RM']);
                $object->setModel($array['Model']);
                $object->setKolor($array['Kolor']);
                $object->setWnetrze($array['Wnetrze']);
                $object->setKlient($array['Klient']);
                $object->setDyspozycjaNaDealera($array['Dyspozycja na Dealera']);
                $object->setDealer($array['Dealer']);
                $object->setVin($array['VIN']);
                $object->setStan($array['Stan']);
                $object->setPakiety($array['Pakiety']);
                $object->setOfertaInternetowa($array['oferta internetowa']);
                $object->setTydzienPlanu($array['Tydzien planu']);
                $object->setIfa($array['IFA/KNP']);
                $object->setZarezerwowany($array['Zarezerwowany']);
                $object->setZamowione($array['Zamowione']);
                $object->setZarez($array['Zarez/Zam.']);
                $object->setWlasciciel($array['Wlasciciel']);
                $object->setPlan($array['Plan']);
                $object->setOdpowiedzZIfa($array['Odpowiedz z IFA']);
                $object->setDataSprzedazy($array['Data sprzedazy']);
                $object->setOznaczenieWyboru($array['Oznaczenie wyboru']);
                $object->setAkcjaMarketingowa($array['Akcja marketingowa']);
                $object->setRodzajDyspozycji($array['Rodzaj dyspozycji']);
                $object->setOdbiorca($array['Odbiorca']);
                $object->setBid($array['BID']);
                $object->setNrSilnika($array['Nr silnika']);
                $object->setDataZamowienia($array['Data zamowienia']);
                $object->setTerminRealizacji($array['Ter. realizacji']);
                $object->setGeoObszar($array['Geo. obszar']);
                $object->setTerminProdukcji($array['Termin produkcji']);
                $object->setMc($array['MC']);
                $object->setGrupaDocelowa($array['Grupa docelowa']);
                $object->setUtworzenieKomisji($array['Utworzenie komisji']);
                $object->setRodzajSprzedazy($array['Rodzaj sprzedazy']);
                $object->setFakturaImporter($array['F. dla imp.']);
                $object->setRodzaj($array['Rodzaj']);

                $em->persist($object);
            }

            $em->flush();

            $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollback();
        }

    }

    private function saveFile(UploadedFile $file)
    {
        $file->move(
            $this->getParameter('kernel.root_dir') . "/Resources/raw",
            "data.csv"
        );
    }

    /**
     * @Route("/admin/addTable", name="adminAddTable")
     */
    public function addTableAction(Request $request)
    {
        $session = new Session();
        $repository = $this->getDoctrine()->getRepository('AppBundle:UsersAdmin');
        if(!UsersAdmin::isAdminLogged($session,$repository))
            return $this->redirectToRoute('adminLogin');

        $data = [];
        $form = $this->createFormBuilder($data)
            ->add('file', FileType::class, array('label' => 'File'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $this->getFile($form);
            $this->validateFile($file);
            $this->processFile($file);
            $this->saveFile($file);

            return $this->render('AppBundle:Admin:add_table.html.twig', [
                'form' => $form->createView()
            ]);
            //return new Response("Success.");
        }

        return $this->render('AppBundle:Admin:add_table.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/login", name="adminLogin")
     */

    public function loginAdminAction(Request $request)
    {
        $form = $this->createFormBuilder(array())
            ->add('email',TextType::class)
            ->add('password',PasswordType::class)
            ->add('login',SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $repository = $this->getDoctrine()->getRepository('AppBundle:UsersAdmin');
            $admin = $repository->findOneBy(array('email'=>$data['email']));
            if(empty($admin)){
                return $this->render('AppBundle:myUser:login_user.html.twig',array('form' => $form->createView()));
            }
            else { // nie ma takiego juzera
                $saltedPassword = UsersAdmin::getSaltedPassword($data['password'], $admin->getSalt());

                if($saltedPassword === $admin->getPass()){
                    //zaloguj
                    $session = new Session();
                    $session->set('adminID',$admin->getID());
                    return $this->redirectToRoute('adminAddTable');

                }
                else {
                    //blad bledne haslo
                }
            }
        }

        return $this->render('AppBundle:myUser:login_user.html.twig',array('form' => $form->createView()));
    }

    /**
     * @Route("/admin/logout", name="adminLogout")
     */

    public function logoutAdminAction(Request $request)
    {
        $session = new Session();
        $session->remove('adminID');
        return $this->redirectToRoute('adminLogin');
    }
}
