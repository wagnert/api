<?php

/**
 * AppserverIo\Apps\Api\Repository\ContainerRepository
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
 * A SLSB implementation providing the business logic to handle containers.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class ContainerRepository extends AbstractRepository implements ContainerRepositoryInterface
{

    /**
     * Returns the container node with the passed ID.
     *
     * @param string $id The ID of the container node to be returned
     *
     * @return \AppserverIo\Appserver\Core\Api\Node\ContainerNodeInterface The requested container node
     */
    public function load($id)
    {
        return $this->newService(ServiceKeys::VIRTUAL_HOST)->load($id);
    }

    /**
     * Returns an array with the available container nodes.
     *
     * @return array The array with the available container nodes
     */
    public function findAll()
    {
        return $this->newService(ServiceKeys::CONTAINER)->findAll();
    }
}
