<?php

/**
 * AppserverIo\Apps\Example\Service\DatasourceProcessorInterface
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
 * to handle datasources.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
interface DatasourceProcessorInterface
{

    /**
     * Returns the document representation of the datasource node with the passed ID.
     *
     * @param string $id The ID of the datasource node to be returned
     *
     * @return \Tobscure\JsonApi\Document The document representation of the datasource node
     */
    public function load($id);


    /**
     * Returns the document representation of all datasource nodes.
     *
     * @return \Tobscure\JsonApi\Document A document representation of the datasource nodes
     */
    public function findAll();
}
