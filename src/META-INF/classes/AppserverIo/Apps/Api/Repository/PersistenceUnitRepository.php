<?php

/**
 * AppserverIo\Apps\Api\Repository\PersistenceUnitRepository
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

use AppserverIo\Psr\Application\ApplicationInterface;

/**
 * A SLSB implementation providing the business logic to handle persistence units.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class PersistenceUnitRepository extends AbstractRepository implements PersistenceUnitRepositoryInterface
{

    /**
     * Returns the persistence unit with the passed ID.
     *
     * @param string $id The ID of the persistence unit to be returned
     *
     * @return \AppserverIo\Appserver\Core\Api\Node\PersistenceUnitNodeInterface The requested persistence node representation
     */
    public function load($id)
    {
        if (array_key_exists($id, $persistenceUnits = $this->findAll())) {
            return $persistenceUnits[$id];
        }
    }

    /**
     * Returns an array with the available naming directories.
     *
     * @return array The array with the available naming directories
     */
    public function findAll()
    {

        // create a local naming directory instance
        $namingDirectory = $this->getNamingDirectory();

        // initialize the array for the persistence units
        $persistenceUnits = array();

        // convert the application nodes into stdClass representation
        foreach ($namingDirectory->search('php:global')->getAllKeys() as $key) {
            try {
                // try to load the application
                $value = $namingDirectory->search(sprintf('php:global/%s/env/ApplicationInterface', $key));

                // query whether we've found an application instance or not
                if ($value instanceof ApplicationInterface) {
                    // load the application's persistence manager
                    /** \AppserverIo\Psr\EnterpriseBeans\PersistenceContextInterface $persistenceManager */
                    $persistenceManager = $value->search('PersistenceContextInterface');

                    // load and merge the persistence units
                    foreach ($persistenceManager->getEntityManagers() as $entityManager) {
                        $persistenceUnits[$entityManager->getName()] = $entityManager;
                    }
                }

            } catch (\Exception $e) {
                // do nothing here, because
            }
        }

        // load the persistence units
        return $persistenceUnits;
    }

    /**
     * Returns an array with the persistence units of the application with the passed name.
     *
     * @param string $applicationName The name of the application to return the persistence units for
     *
     * @return array The array with the application's persistence units
     */
    public function findAllByApplicationName($applicationName)
    {

        // initialize the array for the persistence units
        $persistenceUnits = array();

        // load the application with the passed name
        /** \AppserverIo\Psr\Application\ApplicationInterface $application */
        $application = $this->getNamingDirectory()->search(sprintf('php:global/%s', $applicationName));

        // load the application's persistence manager
        /** \AppserverIo\Psr\EnterpriseBeans\PersistenceContextInterface $persistenceManager */
        $persistenceManager = $application->search('PersistenceContextInterface');

        // prepare the array with the persistence units
        /** \AppserverIo\Appserver\Core\Api\Node\PersistenceUnitNode $entityManager */
        foreach ($persistenceManager->getEntityManagers() as $entityManager) {
            $persistenceUnits[$entityManager->getName()] = $entityManager;
        }

        // load the persistence units
        return $persistenceUnits;
    }
}
