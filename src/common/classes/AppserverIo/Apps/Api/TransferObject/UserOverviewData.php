<?php

/**
 * AppserverIo\Apps\Api\TransferObject\UserOverviewData
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

/**
 * DTO for the user overview data implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @SWG\Definition(type="object", required={"id", "username"})
 */
class UserOverviewData
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
     * @SWG\Property(property="username", type="string")
     */
    protected $username;

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
     * Set's the user's username.
     *
     * @param string $name The user's username
     *
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Return's the user's username.
     *
     * @return string The user's username
     */
    public function getUsername()
    {
        return $this->username;
    }
}
