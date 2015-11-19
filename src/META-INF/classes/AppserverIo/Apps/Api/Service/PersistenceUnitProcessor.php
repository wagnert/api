<?php

/**
 * AppserverIo\Apps\Api\Service\PersistenceUnitProcessor
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
 * A SLSB implementation providing the business logic to handle
 * persistence units.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class PersistenceUnitProcessor implements PersistenceUnitProcessorInterface
{

    /**
     * The application instance that provides the entity manager.
     *
     * @var \AppserverIo\Psr\Application\ApplicationInterface
     * @Resource(name="ApplicationInterface")
     */
    protected $application;

    /**
     * Initializes the stdClass representation of the persistence unit node with
     * the ID passed as parameter.
     *
     * @param string $id The ID of the requested persistence unit node
     *
     * @return \stdClass The persistence unit node as \stdClass representation
     */
    public function load($id)
    {
    }

    /**
     * Returns all persistence units registered by the passed
     * application instance.
     *
     * @param string|null $applicationName The name of the application to return the persistence units for
     *
     * @return array The array with the application's persistence units
     */
    public function findAll($applicationName = null)
    {

        // initialize class container
        $stdClass = new \stdClass();
        $stdClass->persistenceUnits = array();

        $application = $this->application->getNamingDirectory()->search(sprintf('php:global/%s', $applicationName));

        $persistenceManager = $application->search('PersistenceContextInterface');

        // convert the application nodes into stdClass representation
        foreach ($persistenceManager->getEntityManagers() as $entityManager) {
            $stdClass->persistenceUnits[] = $entityManager->toStdClass();
        }

        // return the stdClass representation of the apps
        return $stdClass;
    }
}
