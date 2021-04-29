<?php

/**
 * AppserverIo\Apps\Api\Repository\ContainerRepositoryInterface
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
 * to handle containers.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
interface ContainerRepositoryInterface
{

    /**
     * Returns the container node with the passed ID.
     *
     * @param string $id The ID of the container node to be returned
     *
     * @return \AppserverIo\Psr\ApplicationServer\Configuration\ContainerConfigurationInterface The requested container node
     */
    public function load($id);

    /**
     * Returns an array with the available container nodes.
     *
     * @return array The array with the available container nodes
     */
    public function findAll();
}
