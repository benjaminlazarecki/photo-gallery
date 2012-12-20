<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gallery\Entity\Gallery;

/**
 * Represent the user class.
 *
 * @ORM\Entity(repositoryClass = "User\Repository\UserRepository")
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
     * @var boolean TRUE if account is enable, else FALSE.
     *
     * @ORM\Column(type = "boolean")
     */
    protected $enable;

    /**
     * @var integer attempt login count.
     *
     * @ORM\Column(type = "integer")
     */
    protected $attempt;

    /**
     * @var boolean TRUE if user is admin, else FALSE
     *
     * @ORM\Column(type = "boolean")
     */
    protected $admin;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->setGallery(new Gallery());
        $this->attempt = 0;
        $this->enable = true;
        $this->admin = false;
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
     * @param Gallery $gallery
     */
    public function setGallery(Gallery $gallery)
    {
        $gallery->setOwner($this);
        $this->gallery = $gallery;
    }

    /**
     * Return the id
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
     * Gets the count login attempt.
     *
     * @return integer
     */
    public function getAttempt()
    {
        return $this->attempt;
    }

    /**
     * Add a attempts for login.
     *
     * @return User
     */
    public function addAttempt()
    {
        $this->attempt++;

        return $this;
    }

    /**
     * Reset the attempt login count.
     */
    public function resetAttempt()
    {
        $this->attempt = 0;
    }

    /**
     * Return TRUE if account is enable, else FALSE.
     *
     * @return boolean
     */
    public function isEnable()
    {
        return $this->enable;
    }

    /**
     * Sets TRUE if account is enable, else FALSE.
     *
     * @param boolean $enable
     *
     * @return User
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * Return TRUE if user is admin, else FALSE.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin;
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

