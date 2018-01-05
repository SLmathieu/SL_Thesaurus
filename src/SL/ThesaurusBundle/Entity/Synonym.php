<?php

namespace SL\ThesaurusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Synonym
 *
 * @ORM\Table(name="synonym")
 * @ORM\Entity(repositoryClass="SL\ThesaurusBundle\Repository\SynonymRepository")
 */
class Synonym
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idWord1", type="integer")
     */
    private $idWord1;

    /**
     * @var int
     *
     * @ORM\Column(name="idWord2", type="integer")
     */
    private $idWord2;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idWord1
     *
     * @param integer $idWord1
     *
     * @return Synonym
     */
    public function setIdWord1($idWord1)
    {
        $this->idWord1 = $idWord1;

        return $this;
    }

    /**
     * Get idWord1
     *
     * @return int
     */
    public function getIdWord1()
    {
        return $this->idWord1;
    }

    /**
     * Set idWord2
     *
     * @param integer $idWord2
     *
     * @return Synonym
     */
    public function setIdWord2($idWord2)
    {
        $this->idWord2 = $idWord2;

        return $this;
    }

    /**
     * Get idWord2
     *
     * @return int
     */
    public function getIdWord2()
    {
        return $this->idWord2;
    }
}

