<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

use ZfcUser\Entity\User as ZfcUser;

/**
 * @ORM\Entity
 * @ORM\Table(name = "users")
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class User extends ZfcUser
{
}
