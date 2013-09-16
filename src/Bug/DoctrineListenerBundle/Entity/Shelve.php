<?php

namespace Bug\DoctrineListenerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="shelve")
 */
class Shelve
{
    // MEMBERS

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="smallint", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var integer
     * @ORM\Column(name="name", type="integer", nullable=false)
     */
    protected $number;

    // SPECIAL

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('Shelve(%s)', $this->getName());
    }

    // GET/SET

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param integer $number
     * @return Item
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }
}
