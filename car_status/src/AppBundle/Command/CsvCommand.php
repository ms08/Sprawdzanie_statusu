<?php

namespace AppBundle\Command;

use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CsvCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:csv')
            ->setDescription('Insert CSV file to database');
    }

    protected function execute(InputInterface $i, OutputInterface $o)
    {
        $start = microtime(true);


        $patch =  $this->getContainer()->getParameter('kernel.root_dir') . "/Resources/raw/data.csv";

        $serializer = new Serializer([new ObjectNormalizer()],[new CsvEncoder()]);
        $data = $serializer->decode(file_get_contents($patch),'csv');

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');


        $connection = $em->getConnection();
        $connection->beginTransaction();

        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $connection->query('DELETE FROM task');

            foreach ($data as $array) {


                if(!isset($array['name'])) {
                    throw new \Exception("Incorrect csv structure");
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

        $time_elapsed_secs = microtime(true) - $start;

        $o->writeln("<info>Test contain: ".count($data)." objects. Time elapsed: $time_elapsed_secs.</info>");
    }
}