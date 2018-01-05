<?php
// src/ThesaurusBundle/Services/Thesaurus.php
namespace SL\ThesaurusBundle\Services;

use Symfony\Component\Console\Output\OutputInterface;
use \Exception;

use SL\ThesaurusBundle\Entity\Word;
use SL\ThesaurusBundle\Entity\Synonym;

class Thesaurus
{
    // entity manager
    private $em = null;

    public function __construct($em) {
        $this->em = $em;
    }

    // Adds the given words as synonyms to each other
    public function addSynonyms($arrSynonyms) {

        // counter of synonyms added
        $nbAdd = 0;

        try {
            // the array of words id
            $arrIdWords = array();

            // collecting all the words id
            foreach ($arrSynonyms as $syno) {

                $word = $this->em->getRepository('SLThesaurusBundle:Word')->findOneBy(array("name" => $syno));

                // if the word doesn't exist in the database, we create it
                if (!$word) {

                    $word = new Word();
                    $word->setName($syno);

                    $this->em->persist($word);
                    $this->em->flush();

                    // echo "Word ".$syno." added, id : ".$word->getId()."\n";
                    $arrIdWords[] = $word->getId();
                }

                // avoid the duplication
                if (!in_array($word->getId(), $arrIdWords)) {
                    $arrIdWords[] = $word->getId();
                }

            }


            // adding the synonyms to the database
            $nbWords = count($arrIdWords);
            if ($arrIdWords>1) {

                // we scan twice the array, in order to create all the duos of words, without duplication
                for ($is1=0 ; $is1<= ($nbWords-2) ; $is1++) {

                    // the second scan starts with is2 = is1 (to avoid duplication)
                    for ($is2= ($is1+1) ; $is2<= ($nbWords-1) ; $is2++) {

                        // check if the duo already exists
                        $synonym = $this->em->getRepository('SLThesaurusBundle:Synonym')->findOneBy(
                            array(
                                "idWord1" => $arrIdWords[$is1],
                                "idWord2" => $arrIdWords[$is2]
                            )
                        );

                        // if not, we add the duo
                        if (!$synonym) {
                            $synonym = new Synonym();
                            $synonym->setIdWord1($arrIdWords[$is1]);
                            $synonym->setIdWord2($arrIdWords[$is2]);

                            $this->em->persist($synonym);
                            $this->em->flush();

                            $nbAdd++;
                        }
                    }
                }

            }
            else {
                throw new Exception("Not enough words");
            }

        }
        catch(\Doctrine\ORM\ORMException $e) {
            echo "EXCEPTION : ".$e->getMessage()."\n";
        }
        catch(\Exception $e) {
            echo "EXCEPTION : ".$e->getMessage()."\n";
        }

        return $nbAdd;

    }

    // Returns an array with all the synonyms for a word
    public function getSynonyms($word_input) {

        $arrSynonyms=array();

        try {
            if (!$word_input) {
                throw new Exception("No word given");
            }
            else {
                $word_input = trim($word_input);

                // check if the word exists in the Thesaurus
                $word = $this->em->getRepository('SLThesaurusBundle:Word')->findOneBy(
                    array(
                        "name" => $word_input
                    )
                );

                if (!$word) {
                    throw new Exception("Word unknown in the thesaurus");
                }
                else {
                    $synonyms = $this->em->getRepository('SLThesaurusBundle:Synonym')->findAllSynonymsByWord($word->getId());

                    if ($synonyms) {
                        foreach($synonyms as $syno) {
                            $arrSynonyms[] = $syno["name"];
                        }
                    }
                }

            }

        }
        catch(\Exception $e) {
            echo "EXCEPTION : ".$e->getMessage()."\n";
        }

        return $arrSynonyms;
    }

    // Returns an array with all words that are stored in the thesaurus
    public function getWords() {

        $tabWords = array();

        try {
            $words = $this->em->getRepository('SLThesaurusBundle:Word')->findAll();

            if ($words) {
                foreach ($words as $word) {
                    $tabWords[] = $word->getName();
                }
            }

        }
        catch(\Doctrine\ORM\ORMException $e) {
            echo $e->getMessage();
        }

        return ($tabWords);
    }
}
