<?php

/**
 * AppserverIo\Apps\Api\Service\UserProcessor
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

use AppserverIo\Apps\Api\TransferObject\UserOverviewData;

/**
 * A SLSB implementation providing the business logic to handle users.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateful
 */
class UserProcessor implements UserProcessorInterface
{

    /**
     * The user logged into the system.
     *
     * @var AppserverIo\Apps\Api\TransferObject\UserOverviewData
     */
    protected $user;

    /**
     * The user repository instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy The user repository instance
     * @see \AppserverIo\Apps\Example\Repository\UserRepositoryInterface
     *
     * @EnterpriseBean
     */
    protected $userRepository;

    /**
     * Return's the user respository instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Repository\UserRepositoryInterface
     */
    protected function getUserRepository()
    {
        return $this->userRepository;
    }

    /**
     * Queries whether a user has been logged into the system or not.
     *
     * @return boolean TRUE if a valid user is available, else FALSE
     * @see \AppserverIo\Apps\Example\Service\UserProcessorInterface::isAuthenticated()
     */
    public function isAuthenticated()
    {
        return $this->user instanceof UserOverviewData;
    }

    /**
     * Tries to login the user with the passed name and password.
     *
     * @param string $username The username used to login
     * @param string $password The password used to login
     *
     * @return \AppserverIo\Apps\Api\TransferObject\UserOverviewData The user logged into the system
     * @see \AppserverIo\Apps\Example\Service\UserProcessorInterface::login()
     */
    public function login($username, $password)
    {

        // query whether we already have a user or not
        if ($this->user == null) {
            $this->user = $this->getUserRepository()->login($username, $password);
        }

        // return the user, logged into the system
        return $this->user;
    }
}
