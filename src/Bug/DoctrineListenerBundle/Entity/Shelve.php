<?php

namespace Bug\DoctrineListenerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="shelve")
 */
class Shelve
    extends Base
{
    // MEMBERS

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
