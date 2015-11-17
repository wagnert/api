<?php

/**
 * AppserverIo\Apps\Api\Service\ContainerService
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

/**
 * Service implementation that handles all container related functionality.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class ContainerService extends AbstractService
{

    /**
     * Class name of the persistence container proxy that handles the data.
     *
     * @var string
     */
    const SERVICE_CLASS = 'AppserverIo\Appserver\Core\Api\ContainerService';

    /**
     * Returns all container nodes registered in system configuration.
     *
     * @return \stdClass A \stdClass representation of the container nodes
     * @see \AppserverIo\Api\Service\AbstractService::findAll()
     */
    public function findAll()
    {

        // load all application nodes
        $containerNodes = $this->getApi(self::SERVICE_CLASS)->findAll();

        // initialize class container
        $stdClass = new \stdClass();
        $stdClass->containers = array();

        // convert the container nodes into stdClass representation
        foreach ($containerNodes as $containerNode) {
            // load the receiver information
            $receiverNode = $containerNode->getReceiver();

            // initialize the container stdClass representation
            $container = $containerNode->toStdClass();

            // add address/port + worker number
            $container->address = $receiverNode->getParam('address');
            $container->port = $receiverNode->getParam('port');
            $container->worker_number = $receiverNode->getParam('workerNumber');

            // add the stdClass representation to the array
            $stdClass->containers[] = $container;
        }

        // return the stdClass representation of the apps
        return $stdClass;
    }

    /**
     * Initializes the stdClass representation of the container node with
     * the ID passed as parameter.
     *
     * @param string $id The ID of the requested container node
     *
     * @return \stdClass The container node as \stdClass representation
     */
    public function load($id)
    {

        // load the container with the requested ID
        $containerNode = $this->getApi(self::SERVICE_CLASS)->load($id);

        // initialize a class container
        $stdClass = new \stdClass();
        $stdClass->container = $containerNode->toStdClass();

        // return the stdClass representation of the container
        return $stdClass;
    }
}
