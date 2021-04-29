<?php

/**
 * AppserverIo\Apps\Api\Repository\NamingDirectoryRepository
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

use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;

/**
 * A SLSB implementation providing the business logic to handle naming directories.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @EPB\Stateless
 */
class NamingDirectoryRepository extends AbstractRepository implements NamingDirectoryRepositoryInterface
{

    /**
     * Returns the naming directory with the passed ID.
     *
     * @param string $id The ID of the naming directory to be returned
     *
     * @return \AppserverIo\Psr\Naming\NamingDirectoryInterface The requested naming directory
     */
    public function load($id)
    {
        if (array_key_exists($id, $namingDirectories = $this->findAll())) {
            return $namingDirectories[$id];
        }
    }

    /**
     * Returns an array with the available naming directories.
     *
     * @return array The array with the available naming directories
     */
    public function findAll()
    {
        return array($this->getNamingDirectory()->getSerial() => $this->getNamingDirectory());
    }
}
