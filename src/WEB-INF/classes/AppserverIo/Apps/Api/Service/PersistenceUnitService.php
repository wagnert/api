<?php

/**
 * AppserverIo\Apps\Api\Service\PersistenceUnitService
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
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
namespace AppserverIo\Apps\Api\Service;

use AppserverIo\Appserver\Core\Api\Node\AppNode;

/**
 * Service implementation that handles all app related functionality.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class PersistenceUnitService extends AbstractService
{

    /**
     * Class name of the persistence container proxy that handles the data.
     *
     * @var string
     */
    const SERVICE_CLASS = 'AppserverIo\Appserver\Core\Api\PersistenceUnitService';

    /**
     * Returns all persistence unit nodes registered in system configuration.
     *
     * @return \stdClass A \stdClass representation of the app nodes
     * @see \AppserverIo\Api\Service\AbstractService::findAll()
     */
    public function findAll()
    {

        // load all persistence unit nodes
        $persistenceUnitNodes = $this->getApi(self::SERVICE_CLASS)->findAll();

        // initialize class container
        $stdClass = new \stdClass();
        $stdClass->persistenceUnits = array();

        // convert the persistence unit nodes into stdClass representation
        foreach ($persistenceUnitNodes as $persistenceUnitNode) {
            $stdClass->persistenceUnits[] = $persistenceUnitNode->toStdClass();
        }

        // return the stdClass representation of the persistence units
        return $stdClass;
    }

    /**
     * Returns the app with the passed ID from the system configuration.
     *
     * @param string $id The ID of the app node to be returned
     *
     * @return \stdClass A \stdClass representation of the app node
     * @see \AppserverIo\Api\Service\AbstractService::load()
     */
    public function load($id)
    {

        // load the application with the requested ID
        $appNode = $this->getApi(self::SERVICE_CLASS)->load($id);

        // initialize a class container
        $stdClass = new \stdClass();
        $stdClass->app = $appNode->toStdClass();

        // load the container nodes and append them
        $stdClass->containers = array();
        $containerNodes = $this->getApi(ContainerService::SERVICE_CLASS)->findAll();
        foreach ($containerNodes as $containerNode) {
            if (strstr($appNode->getWebappPath(), $containerNode->getHost()->getAppBase())) {
                $stdClass->containers[] = $containerNode->toStdClass();
            }
        }

        // return the stdClass representation of the app
        return $stdClass;
    }
}
