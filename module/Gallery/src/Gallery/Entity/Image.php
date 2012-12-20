<?php

namespace Gallery\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Represent an image upload by a user.
 *
 * @ORM\Entity
 * @ORM\Table(name = "image")
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\Column(
     *     type     = "string",
     *     length   = 255,
     *     nullable = true
     * )
     */
    public $path;

    /**
     * @var mixed the file.
     */
    public $file;

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
    public function populate($data)
    {
        $this->name    = $data['name'];
        $this->public  = $data['public'];
        $this->order   = $data['order'];
        $this->file    = $data['file'];
    }

    /**
     * Gets the path of the image.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the image path.
     *
     * @param string $path
     *
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Gets the file
     *
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets the file.
     *
     * @param mixed $file
     *
     * @return Image
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Gets the absolute path.
     *
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    /**
     * Gets the web path.
     *
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    /**
     * Gets the upload root dir
     *
     * @return string
     */
    public function getUploadRootDir()
    {
        return getcwd() .$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return '/web/uploads/images/';
    }

    /**
     * On pre upload and pre update rename file.
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            $guessExtension = explode('.', $this->file['name']);
            $this->path = sha1(uniqid(mt_rand(), true)) . '.' . $guessExtension[count($guessExtension) - 1];
        }
    }

    /**
     * On post persist and post update move the file.
     *
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }
        move_uploaded_file($this->file['tmp_name'], $this->getUploadRootDir() . $this->path);
        unset($this->file);
    }

    /**
     * On post remove unlink the file.
     *
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
}
