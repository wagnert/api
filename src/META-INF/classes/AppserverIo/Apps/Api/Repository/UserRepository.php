<?php

/**
 * AppserverIo\Apps\Api\Repository\UserRepository
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

use Rhumsaa\Uuid\Uuid;
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
 * @Stateless
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{

    /**
     * Tries to login the user with the passed name and password.
     *
     * @param string $username The username used to login
     * @param string $password The password used to login
     *
     * @return \AppserverIo\Apps\Api\TransferObject\UserOverviewData The user logged into the system
     * @todo Dummy implementation without any functionality
     */
    public function login($username, $password)
    {
        $user = new UserOverviewData();
        $user->setId(Uuid::uuid4()->__toString());
        $user->setUsername($username);
        return $user;
    }
}
