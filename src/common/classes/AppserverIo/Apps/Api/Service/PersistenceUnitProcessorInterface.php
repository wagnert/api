<?php

/**
 * AppserverIo\Apps\Example\Service\PersistenceUnitProcessorInterface
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
 * to handle persistence units.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
interface PersistenceUnitProcessorInterface
{

    /**
     * Initializes the stdClass representation of the persistence unit node with
     * the ID passed as parameter.
     *
     * @param string $id The ID of the requested persistence unit node
     *
     * @return \stdClass The persistence unit node as \stdClass representation
     */
    public function load($id);

    /**
     * Returns all persistence units registered by the passed
     * application instance.
     *
     * @param string|null $applicationName The name of the application to return the persistence units for
     *
     * @return array The array with the application's persistence units
     */
    public function findAll($applicationName = null);
}
