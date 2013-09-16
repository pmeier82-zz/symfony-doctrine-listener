<?php

namespace Bug\DoctrineListenerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="item")
 */
class Item
    extends Base
{
    // MEMBERS

    /**
     * @var string
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    protected $name;

    /**
     * @var integer
     * @ORM\Column(name="shelve_no", type="integer", nullable=false)
     */
    protected $shelve_number;

    // SPECIAL

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('Item(%s)[%s]', $this->getName(), $this->getShelveNumber());
    }

    // GET/SET

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Item
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return integer
     */
    public function getShelveNumber()
    {
        return $this->shelve_number;
    }

    /**
     * @param integer $shelve_number
     * @return Item
     */
    public function setShelveNumber($shelve_number)
    {
        $this->shelve_number = $shelve_number;
        return $this;
    }
}
