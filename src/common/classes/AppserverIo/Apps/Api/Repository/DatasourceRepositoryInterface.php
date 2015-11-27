<?php

/**
 * AppserverIo\Apps\Example\Repository\DatasourceRepositoryInterface
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
 * to handle datasource nodes.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
interface DatasourceRepositoryInterface
{

    /**
     * Returns the datasource node with the passed ID.
     *
     * @param string $id The ID of the datasource node to be returned
     *
     * @return \AppserverIo\Appserver\Core\Api\DatasourceNodeInterface The requested datasource node
     * @see \AppserverIo\Apps\Api\Service\DatasourceRepositoryInterface::load()
     */
    public function load($id);

    /**
     * Returns an array with the available datasource nodes.
     *
     * @return array The array with the available datasource nodes
     * @see \AppserverIo\Apps\Api\Service\DatasourceRepositoryInterface::findAll()
     */
    public function findAll();
}
