<?php

/**
 * AppserverIo\Apps\Example\Service\UserProcessorInterface
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

namespace AppserverIo\Apps\Api\Service;

/**
 * An interface for SLSB implementations providing the business logic
 * to handle users.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
interface UserProcessorInterface
{

    /**
     * Queries whether a user has been logged into the system or not.
     *
     * @return boolean TRUE if a valid user is available, else FALSE
     */
    public function isAuthenticated();

    /**
     * Returns the authenticated user.
     *
     * @return \AppserverIo\Apps\Api\TransferObject\UserOverviewData The user logged into the system
     * @see \AppserverIo\Apps\Example\Service\UserProcessorInterface::getAuthenticatedUser()
     */
    public function getAuthenticatedUser();

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
