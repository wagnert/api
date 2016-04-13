<?php

/**
 * AppserverIo\Apps\Api\Security\GenericPrincipalDecorator
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Apps\Api\Security;

use AppserverIo\Psr\Security\PrincipalInterface;
use AppserverIo\Appserver\ServletEngine\Security\GenericPrincipal;
use Guzzle\Common\FromConfigInterface;
use AppserverIo\Psr\Security\Auth\Login\LoginContextInterface;

/**
 * Docrator for a GenericPrincipal object.
 *
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2016 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://github.com/appserver-io-apps/api
 * @link       http://www.appserver.io
 */
class GenericPrincipalDecorator implements PrincipalInterface, \JsonSerializable
{

    /**
     * The principal to be decorated.
     *
     * @var \AppserverIo\Appserver\ServletEngine\Security\GenericPrincipal
     */
    protected $principal;

    /**
     * Initialize the decorator with the principal to be decorated.
     *
     * @param \AppserverIo\Appserver\ServletEngine\Security\GenericPrincipal $principal The principal to be decorated
     */
    public function __construct(GenericPrincipal $principal)
    {
        $this->principal = $principal;
    }

    /**
     * Return's the decorated principal.
     *
     * @return \AppserverIo\Appserver\ServletEngine\Security\GenericPrincipal The decorated principal
     */
    public function getPrincipal()
    {
        return $this->principal;
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
        return $this->getPrincipal()->equals($another);
    }

    /**
     * Returns the principals name as string.
     *
     * @return string The principal's name
     */
    public function __toString()
    {
        return $this->getPrincipal()->__toString();
    }

    /**
     * Return's the principals name as String.
     *
     * @return \AppserverIo\Lang\String The principal's name
     */
    public function getName()
    {
        return $this->getPrincipal()->getName();
    }

    /**
     * Return's the principal's username.
     *
     * @return the \AppserverIo\Lang\String The username
     */
    public function getUsername()
    {
        return $this->getPrincipal()->getUsername();
    }

    /**
     * Return's the principal's password.
     *
     * @return the \AppserverIo\Lang\String The password
     */
    public function getPassword()
    {
        return $this->getPrincipal()->getPassword();
    }

    /**
     * Return's the principal's roles.
     *
     * @return the \AppserverIo\Collection\ArrayList The roles
     */
    public function getRoles()
    {
        return $this->getPrincipal()->getRoles();
    }

    /**
     * Return's the user principal instance that will be returned from the request.
     *
     * @return the \AppserverIo\Psr\Security\PrincipalInterface The user principal
     */
    public function getUserPrincipal()
    {
        return $this->getPrincipal()->getUserPrincipal()
    }

    /**
     * Return's the actual login context instance.
     *
     * @return the \AppserverIo\Psr\Security\Auth\Login\LoginContextInterface The login context instance
     */
    public function getLoginContext()
    {
        return $this->getPrincipal()->getLoginContext();
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     *
     * @return mixed The data which can be serialized by json_encode(), which is a value of any type other than a resource
     * @link http://php.net/JsonSerializable
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     */
    public function jsonSerialize()
    {

        $roles = array();
        foreach ($userPrincipal->getRoles() as $role) {
            $roles[] = $role->__toString();
        }

        $principal = array(
            'username' => $userPrincipal->getUsername()->__toString(),
            'roles'    => $roles
        );
    }

    /**
     * Initializes and returns a new instance with the data
     * of the passed JSON string.
     *
     * @param string $json The JSON string to extract the data from
     *
     * @return void
     */
    public static function fromJson($json, LoginContextInterface $loginContext)
    {

    }
}
