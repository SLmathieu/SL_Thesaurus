<?php

namespace SL\ThesaurusBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use SL\ThesaurusBundle\Services\Thesaurus;

class SlThesaurusGetsynonymsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sl:thesaurus:getsynonyms')
            ->setDescription('Display all the synonyms for a word')
            ->addArgument('word', InputArgument::REQUIRED, 'A word')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $word_input = $input->getArgument('word');

        $em = $this->getContainer()->get('doctrine')->getManager();
        $thesaurus = new Thesaurus($em);

        $arrWords = $thesaurus->getSynonyms($word_input);

        if ($arrWords && count($arrWords)>0) {
            $output->writeln('<fg=green>'.count($arrWords).' synonym(s) founded for "'.$word_input.'".</fg=green>');

            foreach($arrWords as $word){
                $output->writeln($word);
            }
        }
        else {
            $output->writeln('<fg=red>No synonym for this word.</fg=red>');
        }


    }

}
