<?php

/**
 * AppserverIo\Apps\Api\Repository\UserRepositoryInterface
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

namespace AppserverIo\Apps\Api\Repository;

/**
 * An interface for SLSB implementations providing the business logic
 * to handle user.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
interface UserRepositoryInterface
{

    /**
     * Tries to login the user with the passed name and password.
     *
     * @param string $username The username used to login
     * @param string $password The password used to login
     *
     * @return \AppserverIo\Apps\Api\TransferObject\UserOverviewData The user logged into the system
     */
    public function login($username, $password);
}
