<?php

namespace Gallery\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;

use User\Entity\User,
    Gallery\Entity\Image;

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
     * Constructor.
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

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
     * @param \User\Entity\User $owner
     *
     * @return Gallery
     */
    public function setOwner(User $owner)
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
     * @param array|ArrayCollection $images
     *
     * @return Gallery
     */
    public function setImages($images)
    {
        foreach($images as $image) {
            $this->addImage($image);
        }

        return $this;
    }

    /**
     * Add image to the gallery.
     *
     * @param Image $image The image.
     *
     * @return Gallery
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;

        return $this;
    }
}

