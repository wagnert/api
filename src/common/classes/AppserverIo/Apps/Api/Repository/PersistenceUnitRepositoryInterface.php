<?php

/**
 * AppserverIo\Apps\Api\Repository\PersistenceUnitRepositoryInterface
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
 * to handle persistence units.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
interface PersistenceUnitRepositoryInterface
{

    /**
     * Returns the naming directory with the passed ID.
     *
     * @param string $id The ID of the naming directory to be returned
     *
     * @return \stdClass The requested naming directory \stdClass representation
     */
    public function load($id);

    /**
     * Returns an array with the available naming directories.
     *
     * @return array The array with the available naming directories
     */
    public function findAll();

    /**
     * Returns an array with the persistence units of the application with the passed name.
     *
     * @param string $applicationName The name of the application to return the persistence units for
     *
     * @return array The array with the application's persistence units
     */
    public function findAllByApplicationName($applicationName);
}
