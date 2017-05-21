<?php
namespace AppBundle\Command;
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
        $patch =  $this->getContainer()->getParameter('kernel.root_dir') . "/Resources/raw/data.csv";

//        $serializer = $this->getContainer()->get('serializer');
        $serializer = new Serializer([new ObjectNormalizer()],[new CsvEncoder()]);

        $data = $serializer->decode(file_get_contents($patch),'csv');
        var_dump($data);
    }
}