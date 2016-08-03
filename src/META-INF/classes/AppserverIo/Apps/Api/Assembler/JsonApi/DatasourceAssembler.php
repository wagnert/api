<?php

/**
 * AppserverIo\Apps\Api\Assembler\JsonApi\DatasourceAssembler
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
use AppserverIo\Appserver\Core\Api\Node\DatasourceNodeInterface;
use AppserverIo\Apps\Api\Assembler\DatasourceAssemblerInterface;
use AppserverIo\Apps\Api\Assembler\JsonApi\Serializer\DatasourceSerializer;

/**
 * A SLSB implementation providing the business logic to assemble datasource nodes
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
class DatasourceAssembler implements DatasourceAssemblerInterface
{

    /**
     * The datasource repository instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Assembler\DatasourceAssemblerInterface
     * @EnterpriseBean
     */
    protected $datasourceTransferObjectAssembler;

    /**
     * Return's the assembler instance.
     *
     * @return AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Assembler\DatasourceAssemblerInterface
     */
    protected function getDatasourceTransferObjectAssembler()
    {
        return $this->datasourceTransferObjectAssembler;
    }

    /**
     * Convert's the passed DTO into a JSON-API document representation.
     *
     * @param \AppserverIo\Apps\Api\TransferObject\DatasourceViewData $datasourceViewData The datasource DTO to convert
     *
     * @return Tobscure\JsonApi\Document The JSON-API document representation
     */
    protected function toDatasourceViewData($datasourceViewData)
    {
        return new Document((new Resource($datasourceViewData, new DatasourceSerializer()))->with('database'));
    }

    /**
     * Convert's the passed datasource DTOs into a JSON-API document representation.
     *
     * @param \AppserverIo\Collections\CollectionInterface $datasources The datasource DTOs to convert
     *
     * @return Tobscure\JsonApi\Document The JSON-API document representation
     */
    protected function toDatasourceOverviewData(CollectionInterface $datasources)
    {

        // create a new collection of naming directories
        $collection = new Collection($datasources->toArray(), new DatasourceSerializer());

        // create a new JSON-API document with that collection as the data
        $document = new Document($collection);

        // add metadata and links
        $document->addMeta('total', $datasources->size());

        // return the JSON-API representation
        return $document;
    }

    /**
     * Returns the a new JSON-API document with the datasource node data.
     *
     * @param string $id The unique ID of the datasource to load
     *
     * @return \Tobscure\JsonApi\Document The document representation of the datasource node
     * @see \AppserverIo\Apps\Api\Assembler\DatasourceAssemblerInterface::getDatasourceViewData()
     */
    public function getDatasourceViewData($id)
    {
        return $this->toDatasourceViewData($this->getDatasourceTransferObjectAssembler()->getDatasourceViewData($id));
    }

    /**
     * Returns the a new JSON-API document with the datasource node array as the data.
     *
     * @return Tobscure\JsonApi\Document The document representation of the datasource nodes
     * @see \AppserverIo\Apps\Api\Assembler\DatasourceAssemblerInterface::getDatasourceOverviewData()
     */
    public function getDatasourceOverviewData()
    {
        return $this->toDatasourceOverviewData($this->getDatasourceTransferObjectAssembler()->getDatasourceOverviewData());
    }
}
