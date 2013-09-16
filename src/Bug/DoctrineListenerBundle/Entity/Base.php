<?php

namespace Bug\DoctrineListenerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class Base
{
    // MEMBERS

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="smallint", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    // SPECIAL

    /**
     * featureless constructor
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Base(' . $this->getId() . ')';
    }

    // GET/SET

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
