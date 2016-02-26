<?php

/**
 * AppserverIo\Apps\Api\TransferObject\UserPrincipal
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

namespace AppserverIo\Apps\Api\TransferObject;

use Swagger\Annotations as SWG;
use AppserverIo\Psr\Security\PrincipalInterface;
use AppserverIo\Lang\String;
use Rhumsaa\Uuid\Uuid;

/**
 * DTO for the user principal.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @SWG\Definition(type="object", required={"id", "name"})
 */
class UserPrincipal implements PrincipalInterface
{

    /**
     * The user UUID.
     *
     * @var string
     * @SWG\Property(property="id", type="string")
     */
    protected $id;

    /**
     * The user name.
     *
     * @var string
     * @SWG\Property(property="name", type="string")
     */
    protected $name;

    /**
     * Set's the user's UUID.
     *
     * @param string $id The user's UUID
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Return's the user's UUID.
     *
     * @return string The user's UUID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Initializes the principal with the user's name.
     *
     * @param \AppserverIo\Lang\String $name The user's name
     */
    public function __construct(String $name)
    {
        $this->setName($name);
        $this->setId(Uuid::uuid4()->__toString());
    }

    /**
     * Set's the user's name.
     *
     * @param \AppserverIo\Lang\String $name The user's name
     *
     * @return void
     */
    public function setName(String $name)
    {
        $this->name = $name->stringValue();
    }

    /**
     * Return's the user's name.
     *
     * @return \AppserverIo\Lang\String The user's name
     */
    public function getName()
    {
        return new String($this->name);
    }

    /**
     * Compare this SimplePrincipal's name against another Principal.
     *
     * @param \AppserverIo\Psr\Security\PrincipalInterface $another The other principal to compare to
     *
     * @return boolean TRUE if name equals $another->getName();
     */
    public function equals(PrincipalInterface $another)
    {

        // query whether or not another principal has been passed
        if ($another instanceof PrincipalInterface) {
            $anotherName = $another->getName();
            $equals = false;
            if ($this->name == null) {
                $equals = $anotherName == null;
            } else {
                $equals = $this->getName()->equals($anotherName);
            }

            // return the flag if the both are equal
            return $equals;
        }

        // return FALSE if they are not equal
        return false;
    }

    /**
     * Returns the principals name as string.
     *
     * @return string The principal's name
     */
    public function __toString()
    {
        return $this->name;
    }
}
