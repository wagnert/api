<?php

/**
 * AppserverIo\Apps\Api\Entities\Role
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Apps\Api\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Doctrine entity that represents a role.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class Role
{

    /**
     * The unique role ID.
     *
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * The parent role ID.
     *
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $roleIdFk;

    /**
     * The ID of the user the role is bound to.
     *
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $userIdFk;

    /**
     * The role name.
     *
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * The user the role is bound to.
     *
     * @var \AppserverIo\Apps\Api\Entities\User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="roles", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumn(name="userIdFk", referencedColumnName="id")
     */
    protected $user;

    /**
     * Returns the value of the class member id.
     *
     * @return integer Holds the value of the class member id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value for the class member id.
     *
     * @param integer $id Holds the value for the class member id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Returns the value of the class member roleIdFk.
     *
     * @return integer Holds the value of the class member roleIdFk
     */
    public function getRoleIdFk()
    {
        return $this->roleIdFk;
    }

    /**
     * Sets the value for the class member roleIdFk.
     *
     * @param integer $roleIdFk Holds the value for the class member roleIdFk
     *
     * @return void
     */
    public function setRoleIdFk($roleIdFk = null)
    {
        $this->roleIdFk = $roleIdFk;
    }

    /**
     * Set's the user the role is bound to.
     *
     * @return \AppserverIo\Apps\Example\Entities\Impl\User $user The user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set's the user the role is bound to.
     *
     * @param \AppserverIo\Apps\Example\Entities\Impl\User $user The user
     *
     * @return void
     */
    public function setUser($user = null)
    {
        $this->user = $user;
    }

    /**
     * Returns the value for the class member userIdFk.
     *
     * @return integer Holds the value for the class member userIdFk
     */
    public function getUserIdFk()
    {
        return $this->userIdFk;
    }

    /**
     * Sets the value for the class member userIdFk.
     *
     * @param integer $userIdFk Holds the value for the class member userIdFk
     *
     * @return void
     */
    public function setUserIdFk($userIdFk = null)
    {
        $this->userIdFk = $userIdFk;
    }

    /**
     * Returns the value of the class member name.
     *
     * @return string Holds the value of the class member name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value for the class member name.
     *
     * @param string $name Holds the value for the class member name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
