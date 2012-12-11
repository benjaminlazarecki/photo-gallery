<?php

namespace Gallery\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Represent a user gallery.
 *
 * @ORM\Entity(repositoryClass = "Gallery\Repository\GalleryRepository")
 * @ORM\Table(name = "gallery")
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class Gallery
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var User The owner of the gallery.
     *
     * @ORM\OneToOne(targetEntity = "\User\Entity\User")
     * @ORM\JoinColumn(
     *      name                 = "owner_id",
     *      referencedColumnName = "user_id"
     * )
     */
    private $owner;

    /**
     * @var array The images.
     *
     * @ORM\OneToMany(
     *      targetEntity = "Image",
     *      mappedBy     = "gallery"
     * )
     */
    private $images;

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id.
     *
     * @param integer $id
     *
     * @return Gallery
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get gallery owner.
     *
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set order.
     *
     * @param User $owner
     *
     * @return Gallery
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get images.
     *
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set image.
     *
     * @param array $images
     *
     * @return Gallery
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }
}
