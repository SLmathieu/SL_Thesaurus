<?php

namespace SL\ThesaurusBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use SL\ThesaurusBundle\Services\Thesaurus;

class SlThesaurusGetwordsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sl:thesaurus:getwords')
            ->setDescription('Display all the words that are stored in the thesaurus')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $em = $this->getContainer()->get('doctrine')->getManager();
        $thesaurus = new Thesaurus($em);

        $arrWords = array();
        $arrWords = $thesaurus->getWords();

        if (count($arrWords)>0) {
            $output->writeln('<fg=green>'.count($arrWords).' word(s) in the Thesaurus.</fg=green>');

            // sorting the array
            asort($arrWords);

            foreach ($arrWords as $word) {
                $output->writeln($word);
            }
        }
        else {
            $output->writeln('<fg=red>No word in the Thesaurus.</fg=red>');
        }

    }

}
