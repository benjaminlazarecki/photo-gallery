<?php

namespace User\Model;

/**
 * Represent a user.
 *
 * @author benjamin.lazarecki@gmail.com
 */
class User
{
    private $id;
    private $username;
    private $email;
    private $age;
    private $password;
    private $createAt;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createAt = new \DateTime();
    }

    /**
     * @param integer $id
     *
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $age
     *
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
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
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
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
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
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
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id']))             ? $data['id']       : null;
        $this->username = (isset($data['username'])) ? $data['username'] : null;
        $this->email = (isset($data['email']))       ? $data['email']    : null;
        $this->age = (isset($data['age']))           ? $data['age']      : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
    }
}
