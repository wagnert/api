<?php

/**
 * AppserverIo\Apps\Api\Service\VirtualHostService
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
 * Service implementation that handles all vhost related functionality.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class VirtualHostService extends AbstractService
{

    /**
     * Class name of the persistence container proxy that handles the data.
     *
     * @var string
     */
    const SERVICE_CLASS = 'AppserverIo\Appserver\Core\Api\VirtualHostService';

    /**
     * Returns all vhost nodes registered in system configuration.
     *
     * @return \stdClass A \stdClass representation of the vhost nodes
     * @see \AppserverIo\Api\Service\AbstractService::findAll()
     */
    public function findAll()
    {

        // load all container nodes
        $containerNodes = $this->getApi(ContainerService::SERVICE_CLASS)->findAll();

        // initialize class container
        $stdClass = new \stdClass();
        $stdClass->vhosts = array();

        // load the app nodes
        $appNodes = $this->getApi(AppService::SERVICE_CLASS)->findAll();

        // convert the vhost nodes into stdClass representation
        foreach ($containerNodes as $containerNode) {
            // load the host node and iterate over all vhost nodes
            $hostNode = $containerNode->getHost();
            foreach ($containerNode->getServers() as $serverNode) {
                // load the virtual hosts from the server nodes
                foreach ($serverNode->getVirtualHosts() as $vhostNode) {
                    // prepare the base directory (the app nodes primary key)
                    $appBase = $hostNode->getAppBase() . $vhostNode->getParam('documentRoot');
                    $baseDirectory = $this->getApi(self::SERVICE_CLASS)->getBaseDirectory($appBase);

                    // create the vhost stdClass representation
                    $vhost = $vhostNode->toStdClass();

                    // add container name
                    $vhost->container_name = $containerNode->getName();

                    // add address/port number
                    $vhost->address = $serverNode->getParam('address');
                    $vhost->port = $serverNode->getParam('port');

                    // try to load the vhost's app node
                    if (array_key_exists($baseDirectory, $appNodes)) {
                        $vhost->app = $appNodes[$baseDirectory]->getPrimaryKey();
                    }

                    // add the vhost stdClass representation to the array
                    $stdClass->vhosts[] = $vhost;
                }
            }
        }

        // return the stdClass representation of the vhosts
        return $stdClass;
    }

    /**
     * Initializes the stdClass representation of the vhost node with
     * the ID passed as parameter.
     *
     * @param string $id The ID of the requested vhost node
     *
     * @return \stdClass The vhost node as \stdClass representation
     */
    public function load($id)
    {

        // load the vhost with the requested ID
        $vhostNode = $this->getApi(self::SERVICE_CLASS)->load($id);

        // initialize a class container
        $stdClass = new \stdClass();
        $stdClass->vhost = $vhostNode->toStdClass();

        // return the stdClass representation of the vhost
        return $stdClass;
    }
}
