<?php

namespace SL\ThesaurusBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use SL\ThesaurusBundle\Services\Thesaurus;

class SlThesaurusAddsynonymsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sl:thesaurus:addsynonyms')
            ->setDescription('Adds the given words as synonyms to each other')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $thesaurus = new Thesaurus($em);

        $arraySynonyms = array("arbeta", "jobba", "vara anställd ", "jobba");
        $nbAdd = $thesaurus->addSynonyms($arraySynonyms);

        $arraySynonyms = array("done", "made", "accomplished ", "realized");
        $nbAdd = $thesaurus->addSynonyms($arraySynonyms);

        if ($nbAdd && $nbAdd>0) {
            $output->writeln('<fg=green>'.$nbAdd.' synonym(s) added.</fg=green>');
        }
        else {
            $output->writeln('<fg=red>No synonyms added.</fg=red>');
        }
    }

}
