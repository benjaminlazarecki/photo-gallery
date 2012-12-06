<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

use ZfcUser\Entity\User as ZfcUser;

/**
 * @ORM\Entity
 * @ORM\Table(name = "users")
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class User extends ZfcUser
{
    /**
     * @var integer the age.
     *
     * @ORM\Column(type = "integer")
     */
    private $age;

    /**
     * Gets the user age.
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set the user age.
     *
     * @param integer $age
     *
     * @return \User\Entity\User
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }
}
