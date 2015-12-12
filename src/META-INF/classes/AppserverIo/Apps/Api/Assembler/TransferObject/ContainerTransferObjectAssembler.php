<?php

/**
 * AppserverIo\Apps\Api\Assembler\TransferObject\ContainerTransferObjectAssembler
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

namespace AppserverIo\Apps\Api\Assembler\TransferObject;

use AppserverIo\Apps\Api\Assembler\ContainerAssemblerInterface;
use AppserverIo\Appserver\Core\Api\Node\ContainerNodeInterface;

/**
 * A SLSB implementation providing the business logic to assemble containers into DTOs.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class ContainerTransferObjectAssembler implements ContainerAssemblerInterface
{

    /**
     * Returns the a new JSON-API document with the container node data.
     *
     * @param \AppserverIo\Appserver\Core\Api\Node\ContainerNodeInterface $containerNode The container node to assemble
     *
     * @return \Tobscure\JsonApi\Document The document representation of the container node
     * @see \AppserverIo\Apps\Api\Assembler\ContainerAssemblerInterface::getContainerViewData()
     */
    public function getContainerViewData(ContainerNodeInterface $containerNode)
    {
    }

    /**
     * Returns the a new JSON-API document with the container node array as the data.
     *
     * @param array $containers The array with the container nodes to assemble
     *
     * @return \Tobscure\JsonApi\Document The document representation of the container nodes
     * @see \AppserverIo\Apps\Api\Assembler\ContainerAssemblerInterface::getContainerOverviewData()
     */
    public function getContainerOverviewData(array $containers)
    {
    }
}
