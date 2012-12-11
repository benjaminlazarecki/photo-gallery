<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM,
    ZfcUser\Entity\User as ZfcUser;

use Gallery\Entity\Gallery;

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
    protected $age;

    /**
     * @var \Gallery\Entity\Gallery The user gallery.
     *
     * @ORM\OneToOne(
     *      targetEntity = "\Gallery\Entity\Gallery",
     *      cascade      = { "persist" }
     * )
     * @ORM\JoinColumn(name = "gallery_id")
     */
    protected $gallery;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->setGallery(new Gallery());
    }

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

    /**
     * Return user gallery.
     *
     * @return \Gallery\Entity\Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set the user gallery
     *
     * @param \Gallery\Entity\Gallery $gallery
     */
    public function setGallery(Gallery $gallery)
    {
        $gallery->setOwner($this);
        $this->gallery = $gallery;
    }
}
