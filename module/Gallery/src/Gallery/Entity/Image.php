<?php

namespace Gallery\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Represent an image upload by a user.
 *
 * @ORM\Entity
 * @ORM\Table(name = "image")
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string The image name.
     *
     * @ORM\Column(
     *      type   = "string",
     *      length = 255
     * )
     */
    private $name;

    /**
     * @var Gallery The gallery who contain this image.
     *
     * @ORM\ManyToOne(
     *      targetEntity = "Gallery",
     *      inversedBy   = "images"
     * )
     * @ORM\JoinColumn(name = "gallery_id")
     */
    private $gallery;

    /**
     * @var boolean TRUE if the image is public, else FALSE.
     *
     * @ORM\Column(type = "boolean")
     */
    private $public;

    /**
     * @var null|integer The order in gallery.
     *
     * NULL if image is not public, else integer
     *
     * @ORM\Column(
     *      name     = "position",
     *      type     = "integer",
     *      nullable = true
     * )
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
        $gallery->addImage($this);
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

