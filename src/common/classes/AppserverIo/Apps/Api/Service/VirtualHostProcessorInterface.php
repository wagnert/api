<?php

/**
 * AppserverIo\Apps\Example\Service\VirtualHostProcessorInterface
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
 * to handle virtual hosts.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
interface VirtualHostProcessorInterface
{

    /**
     * Returns the document representation of the virtual host node with the passed ID.
     *
     * @param string $id The ID of the virtual host node to be returned
     *
     * @return \Tobscure\JsonApi\Document The document representation of the virtual host node
     */
    public function load($id);

    /**
     * Returns the document representation of all virtual host nodes.
     *
     * @return \Tobscure\JsonApi\Document A document representation of the virtual host nodes
     */
    public function findAll();
}
