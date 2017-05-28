<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class GenerateCsvCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:generate:csv')
            ->setDescription('Generate CSV file for performance tests')
            ->setDefinition(
                new InputDefinition(array(
                    new InputArgument('n', InputArgument::OPTIONAL,'number of lines of generated file',10),
                    )
                )
            );
    }
    
    protected function execute(InputInterface $i, OutputInterface $o)
    {
        $patch =  $this->getContainer()->getParameter('kernel.root_dir') . "/Resources/raw/data.csv";

        $file = fopen($patch,'w');
        fwrite($file,"name\n");
        $n = $i->getArgument('n');
        while($n -- >0) {
            fwrite($file,md5(uniqid())."\n");
        }
        fclose($file);

        $o->writeln("<info>File generated correctly</info>");
    }
}