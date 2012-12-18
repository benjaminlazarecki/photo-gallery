<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gallery\Entity\Gallery;

/**
 * Represent the user class.
 *
 * @ORM\Entity
 * @ORM\Table(name = "users")
 *
 * @ORM\HasLifecycleCallbacks
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class User
{
    /**
     * @var integer id.
     *
     * @ORM\Id
     * @ORM\Column(
     *      type = "integer",
     *      name = "user_id"
     * )
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string username.
     *
     * @ORM\Column(
     *      type   = "string",
     *      length = 255
     * )
     */
    protected $username;

    /**
     * @var string email.
     *
     * @ORM\Column(
     *      type   = "string",
     *      length = 255
     * )
     */
    protected $email;

    /**
     * @var string password.
     *
     * @ORM\Column(
     *      type   = "string",
     *      length = 255
     * )
     */
    protected $password;

    /**
     * @var string the plain password.
     */
    protected $plainPassword;

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
     *      cascade      = { "all" }
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

    /**
     * Gets the id.
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email.
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Gets the username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Gets the password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Gets the password.
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Sets the plainPassword.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;

        return $this;
    }

    /**
     * Generate random password.
     *
     * @param integer $lenght The password length
     *
     * @return string The generate password.
     */
    public function generatePassword($lenght = 6)
    {
        $dico = 'abcdefghijklmnopkrst0123456789';

        $password = '';
        for ($i=0; $i < $lenght; $i++) {
            $password .= $dico[rand(0, mb_strlen($dico) - 1)];
        }

        return $password;
    }

    /**
     * Populate the user.
     *
     * @param array $data The form data.
     */
    public function populate(array $data)
    {
        $this->email    = $data['email'];
        $this->username = $data['username'];
        $this->age      = (integer) $data['age'];
    }

    /**
     * Encrypt password on pre persist and preupdate if plainPassword is not null.
     * 
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function encryptPassword()
    {
        $plainPassword = $this->getPlainPassword();

        if ($plainPassword !== null) {
            $this->setPassword(sha1($plainPassword));
        }
    }
}

