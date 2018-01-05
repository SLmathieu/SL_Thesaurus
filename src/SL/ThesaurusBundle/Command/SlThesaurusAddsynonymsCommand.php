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

        $arrFiles = array();
        $path = $this->getContainer()->get('kernel')->getRootDir(). "/../". $this->getContainer()->getParameter('path_upload_synonyms_files');

        // scan the directory with the synonyms files
        if ($handle = opendir($path))
        {
            while (false !== ($file = readdir($handle)))
                if ($file != '.' && $file != '..' && strstr($file, ".txt"))
                    $arrFiles[] = $path.$file;

            closedir($handle);
        }

        if (count($arrFiles)>0) {
            // scan each txt file with synonyms
            foreach ($arrFiles as $file) {
                // convert the file to an array of lines
                $lines = file($file);
                // counter of lines in the file
                $linecounter = 0;
                foreach ($lines as $line) {
                    $linecounter++;
                    // delete the end-of-lines caracters
                    $line=str_replace("\n", "", $line);
                    $line=str_replace("\r", "", $line);

                    // convert the line in an array of words
                    $expl = explode (",", $line);
                    $arraySynonyms = array();
                    foreach ($expl as $word) {
                        $arraySynonyms[] = trim($word);
                    }

                    $nbAdd = $thesaurus->addSynonyms($arraySynonyms);

                    if ($nbAdd && $nbAdd>0) {
                        $output->writeln('<fg=green>'.$file." - line".$linecounter." => ".$nbAdd.' synonym(s) added.</fg=green>');
                    }
                    else {
                        $output->writeln('<fg=red>'.$file." - line".$linecounter." => ".' No synonyms added.</fg=red>');
                    }
                }
            }
        }
        else {
            $output->writeln('<fg=red>No file to process</fg=red>');
        }
    }

}
