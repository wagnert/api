<?php

/**
 * AppserverIo\Apps\Api\Assembler\JsonApi\ContainerAssembler
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
use AppserverIo\Apps\Api\Assembler\ContainerAssemblerInterface;
use AppserverIo\Apps\Api\Assembler\JsonApi\Serializer\ContainerSerializer;
use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;

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
 * @EPB\Stateless
 */
class ContainerAssembler implements ContainerAssemblerInterface
{

    /**
     * The container repository instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Assembler\ContainerAssemblerInterface
     *
     * @EPB\EnterpriseBean
     */
    protected $containerTransferObjectAssembler;

    /**
     * Return's the assembler instance.
     *
     * @return AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Assembler\ContainerAssemblerInterface
     */
    protected function getContainerTransferObjectAssembler()
    {
        return $this->containerTransferObjectAssembler;
    }

    /**
     * Convert's the passed DTO into a JSON-API document representation.
     *
     * @param \AppserverIo\Apps\Api\TransferObject\ContainerViewData $containerViewData The virtual host DTO to convert
     *
     * @return Tobscure\JsonApi\Document The JSON-API document representation
     */
    protected function toContainerViewData($containerViewData)
    {
        return new Document(new Resource($containerViewData, new ContainerSerializer()));
    }

    /**
     * Convert's the passed virtual host DTOs into a JSON-API document representation.
     *
     * @param \AppserverIo\Collections\CollectionInterface $containers The container DTOs to convert
     *
     * @return Tobscure\JsonApi\Document The JSON-API document representation
     */
    protected function toContainerOverviewData(CollectionInterface $containers)
    {

        // create a new collection of naming directories
        $collection = new Collection($containers->toArray(), new ContainerSerializer());

        // create a new JSON-API document with that collection as the data
        $document = new Document($collection);

        // add metadata and links
        $document->addMeta('total', $containers->size());

        // return the JSON-API representation
        return $document;
    }

    /**
     * Returns the a new JSON-API document with the container data.
     *
     * @param string $id The unique ID of the container to load
     *
     * @return \Tobscure\JsonApi\Document The document representation of the container
     * @see \AppserverIo\Apps\Api\Assembler\ContainerAssemblerInterface::getContainerViewData()
     */
    public function getContainerViewData($id)
    {
        return $this->toContainerViewData($this->getContainerTransferObjectAssembler()->getContainerViewData($id));
    }

    /**
     * Returns the a new JSON-API document with the container array as the data.
     *
     * @return \Tobscure\JsonApi\Document The document representation of the containers
     * @see \AppserverIo\Apps\Api\Assembler\ContainerAssemblerInterface::getContainerOverviewData()
     */
    public function getContainerOverviewData()
    {
        return $this->toContainerOverviewData($this->getContainerTransferObjectAssembler()->getContainerOverviewData());
    }
}
