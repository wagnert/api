<?php

/**
 * AppserverIo\Apps\Api\Assembler\JsonApi\VirtualHostAssembler
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

namespace AppserverIo\Apps\Api\Assembler\JsonApi;

use Tobscure\JsonApi\Resource;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Collection;
use AppserverIo\Apps\Api\Serializer\VirtualHostSerializer;
use AppserverIo\Apps\Api\Assembler\VirtualHostAssemblerInterface;
use AppserverIo\Appserver\Core\Api\Node\VirtualHostNodeInterface;

/**
 * A SLSB implementation providing the business logic to assemble virtual hosts
 * to a JSON-API compatible format.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class VirtualHostAssembler implements VirtualHostAssemblerInterface
{

    /**
     * Returns the a new JSON-API document with the virtual host data.
     *
     * @param \AppserverIo\Appserver\Core\Api\Node\VirtualHostNode $virtualHostNode The virtual host to assemble
     *
     * @return \Tobscure\JsonApi\Document The document representation of the virtual host
     * @see \AppserverIo\Apps\Api\Assembler\VirtualHostAssemblerInterface::getVirtualHostViewData()
     */
    public function getVirtualHostViewData(VirtualHostNodeInterface $virtualHostNode)
    {
        return new Document(new Resource($virtualHostNode, new VirtualHostSerializer()));
    }

    /**
     * Returns the a new JSON-API document with the virtual host array as the data.
     *
     * @param array $entityManagers The array with the virtual hosts to assemble
     *
     * @return \Tobscure\JsonApi\Document The document representation of the virtual hosts
     * @see \AppserverIo\Apps\Api\Assembler\VirtualHostAssemblerInterface::getVirtualHostOverviewData()
     */
    public function getVirtualHostOverviewData(array $virtualHosts)
    {

        // create a new collection of naming directories
        $collection = new Collection($virtualHosts, new VirtualHostSerializer());

        // create a new JSON-API document with that collection as the data
        $document = new Document($collection);

        // add metadata and links
        $document->addMeta('total', count($virtualHosts));

        // return the stdClass representation of the naming directories
        return $document;
    }
}
