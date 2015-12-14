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
use AppserverIo\Collections\CollectionInterface;
use AppserverIo\Appserver\Core\Api\Node\VirtualHostNodeInterface;
use AppserverIo\Apps\Api\Assembler\VirtualHostAssemblerInterface;
use AppserverIo\Apps\Api\Assembler\JsonApi\Serializer\VirtualHostSerializer;

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
     * The virtual host repository instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Assembler\VirtualHostAssemblerInterface
     * @EnterpriseBean
     */
    protected $virtualHostTransferObjectAssembler;

    /**
     * Return's the assembler instance.
     *
     * @return AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Assembler\VirtualHostAssemblerInterface
     */
    protected function getVirtualHostTransferObjectAssembler()
    {
        return $this->virtualHostTransferObjectAssembler;
    }

    /**
     * Convert's the passed DTO into a JSON-API document representation.
     *
     * @param \AppserverIo\Appserver\Core\Api\Node\VirtualHostNodeInterface $virtualHostNode The virtual host node to convert
     *
     * @return Tobscure\JsonApi\Document The JSON-API document representation
     */
    protected function toVirtualHostViewData($virtualHostViewData)
    {
        return new Document(new Resource($virtualHostViewData, new VirtualHostSerializer()));
    }

    /**
     * Convert's the passed virtual host DTOs into a JSON-API document representation.
     *
     * @param \AppserverIo\Collections\CollectionInterfae $virtualHosts The virtual host DTOs to convert
     *
     * @return Tobscure\JsonApi\Document The JSON-API document representation
     */
    protected function toVirtualHostOverviewData(CollectionInterface $virtualHosts)
    {

        // create a new collection of naming directories
        $collection = new Collection($virtualHosts->toArray(), new VirtualHostSerializer());

        // create a new JSON-API document with that collection as the data
        $document = new Document($collection);

        // add metadata and links
        $document->addMeta('total', count($virtualHosts));

        // return the stdClass representation of the naming directories
        return $document;
    }

    /**
     * Returns the a new JSON-API document with the virtual host data.
     *
     * @param string $id The unique ID of the virtual host to load
     *
     * @return \Tobscure\JsonApi\Document The document representation of the virtual host
     * @see \AppserverIo\Apps\Api\Assembler\VirtualHostAssemblerInterface::getVirtualHostViewData()
     */
    public function getVirtualHostViewData($id)
    {
        return $this->toVirtualHostViewData($this->getVirtualHostTransferObjectAssembler()->getVirtualHostViewData($id));
    }

    /**
     * Returns the a new JSON-API document with the virtual host array as the data.
     *
     * @return \Tobscure\JsonApi\Document The document representation of the virtual hosts
     * @see \AppserverIo\Apps\Api\Assembler\VirtualHostAssemblerInterface::getVirtualHostOverviewData()
     */
    public function getVirtualHostOverviewData()
    {
        return $this->toVirtualHostOverviewData($this->getVirtualHostTransferObjectAssembler()->getVirtualHostOverviewData());
    }
}
