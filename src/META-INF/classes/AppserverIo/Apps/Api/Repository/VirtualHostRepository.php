<?php

/**
 * AppserverIo\Apps\Api\Repository\VirtualHostRepository
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

use AppserverIo\Apps\Api\Utils\ServiceKeys;

/**
 * A SLSB implementation providing the business logic to handle virtual hosts.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class VirtualHostRepository extends AbstractRepository implements VirtualHostRepositoryInterface
{

    /**
     * Returns the virtual host node with the passed ID.
     *
     * @param string $id The ID of the virtual host node to be returned
     *
     * @return \AppserverIo\Appserver\Core\Api\Node\VirtualHostNodeInterface The requested virtual host node
     */
    public function load($id)
    {
        return $this->newService(ServiceKeys::VIRTUAL_HOST)->load($id);
    }

    /**
     * Returns an array with the available virtual host nodes.
     *
     * @return array The array with the available virtual host nodes
     */
    public function findAll()
    {

        // initialize the array with the virtual host nodes
        $virtualHosts = array();

        // load all container nodes
        $containerNodes = $this->newService(ServiceKeys::CONTAINER)->findAll();

        // load the virtual host nodes of all containers/servers
        foreach ($containerNodes as $containerNode) {
            foreach ($containerNode->getServers() as $serverNode) {
                foreach ($serverNode->getVirtualHosts() as $virtualHostNode) {
                    $virtualHosts[] = $virtualHostNode;
                }
            }
        }

        // return the virtual hosts
        return $virtualHosts;
    }
}
