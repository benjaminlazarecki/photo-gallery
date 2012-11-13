<?php

namespace Gallery\Model;

/**
 * Represent an image upload by a user.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class Image
{
    /**
     * @var integer Id.
     */
    private $id;

    /**
     * @var string The image name.
     */
    private $name;

    /**
     * @var Gallery The gallery who contain this image.
     */
    private $gallery;

    /**
     * @var boolean TRUE if the image is public, else FALSE.
     */
    private $public;

    /**
     * @var null|integer The order in gallery.
     *
     * NULL if image is not public, else integer
     */
    private $order;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->public = false;
        $this->order = null;
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
     * Set id.
     *
     * @param integer $id
     *
     * @return Image
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets gallery.
     *
     * @return Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set gallery.
     *
     * @param Gallery $gallery
     *
     * @return Image
     */
    public function setGallery(Gallery $gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Image
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Return TRUE if image is public, else FALSE.
     *
     * @return boolean
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * Set is public TRUE if image is public, else FALSE.
     *
     * @param boolean $public
     *
     * @return Image
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get order.
     *
     * @return integer|null
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set order.
     *
     * @param integer|null $order
     *
     * @return Image
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * This method is use by controller for bind form.
     *
     * @param array $data
     */
    public function exchangeArray($data)
    {
        $this->id      = (isset($data['id']))      ? $data['id']      : null;
        $this->name    = (isset($data['name']))    ? $data['name']    : null;
        $this->gallery = (isset($data['gallery'])) ? $data['gallery'] : null;
        $this->public  = (isset($data['public']))  ? $data['public']  : null;
        $this->order   = (isset($data['order']))   ? $data['order']   : null;
    }
}
