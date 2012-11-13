<?php

namespace Gallery\Model;

/**
 * Represent a user gallery.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class Gallery
{
    /**
     * @var integer Id.
     */
    private $id;

    /**
     * @var User The owner of the gallery.
     */
    private $owner;

    /**
     * @var array The images.
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
