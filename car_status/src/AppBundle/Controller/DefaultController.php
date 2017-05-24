<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    /**
     * @param FormInterface $form
     * @return UploadedFile
     */
    private function getFile(FormInterface $form) {
        return $file = $form->getData()['file'];
    }

    private function validateFile(UploadedFile $file) {
        if($file->getClientOriginalExtension()!=="csv") {
            throw new InvalidArgumentException("File should has extension CSV");
        };

        if($file->guessExtension()!=="txt") {
            throw new InvalidArgumentException("File should has textual content");
        };
    }

    private function processFile(UploadedFile $file) {
        $content = file_get_contents($file->getRealPath());

        $serializer = new Serializer([new ObjectNormalizer()],[new CsvEncoder()]);
        $data = $serializer->decode($content,'csv');

        $em = $this->getDoctrine()->getManager();


        $connection = $em->getConnection();
        $connection->beginTransaction();

        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $connection->query('DELETE FROM task');

            foreach ($data as $array) {


                if(!isset($array['name'])) {
                    throw new Exception("Incorrect csv structure");
                }

                $object = new Task();
                $object->setName($array['name']);
                $em->persist($object);
            }

            $em->flush();

            $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollback();
        }

    }

    private function saveFile(UploadedFile $file) {
        $file->move(
            $this->getParameter('kernel.root_dir') . "/Resources/raw",
            "data.csv"
        );
    }

    /**
     * @Route("/", name="home")
     */
    public function indexAction(Request $request)
    {
        $data = [];
        $form  = $this->createFormBuilder($data)
            ->add('file',FileType::class,array('label'=>'File'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $file = $this->getFile($form);
            $this->validateFile($file);
            $this->processFile($file);
            $this->saveFile($file);

            return new Response("Success.");
        }

        return $this->render(':default:index.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/all", name="all")
     */
    public function allAction(Request $request)
    {
        return new Response("for all");
    }

    /**
     * @Route("/restricted", name="restricted")
     */
    public function restrictedAction(Request $request)
    {
        return new Response("secret");
    }
}
