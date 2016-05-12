<?php

/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 06.01.16
 * Time: 14:05
 */
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation as JMS;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @JMS\ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose()
     * @JMS\Groups({"default"})
     */
    protected $id;

    /**
     * @JMS\Expose()
     * @JMS\Groups({"default"})
     */
    protected $email;

    /**
     * @JMS\Expose()
     * @JMS\Groups({"default"})
     */
    protected $username;

    /**
     * @JMS\Expose()
     * @JMS\Groups({"default"})
     */
    protected $roles;

    public function __construct()
    {
        parent::__construct();
    }

    public function setId($id){
        $this->id = $id;
    }
}