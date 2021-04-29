<?php

/**
 * AppserverIo\Apps\Api\Assembler\JsonApi\PersistenceUnitAssembler
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
use AppserverIo\Apps\Api\Assembler\PersistenceUnitAssemblerInterface;
use AppserverIo\Apps\Api\Assembler\JsonApi\Serializer\PersistenceUnitSerializer;
use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;

/**
 * A SLSB implementation providing the business logic to assemble persistence units
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
class PersistenceUnitAssembler implements PersistenceUnitAssemblerInterface
{

    /**
     * The datasource repository instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Assembler\DatasourceAssemblerInterface
     *
     * @EPB\EnterpriseBean
     */
    protected $persistenceUnitTransferObjectAssembler;

    /**
     * Return's the assembler instance.
     *
     * @return AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Assembler\PersistenceUnitAssemblerInterface
     */
    public function getPersistenceUnitTransferObjectAssembler()
    {
        return $this->persistenceUnitTransferObjectAssembler;
    }

    /**
     * Convert's the passed DTO into a JSON-API document representation.
     *
     * @param \AppserverIo\Apps\Api\TransferObject\PersistenceUnitViewData $persistenceUnitViewData The persistence unit DTO to convert
     *
     * @return Tobscure\JsonApi\Document The JSON-API document representation
     */
    public function toPersistenceUnitViewData($persistenceUnitViewData)
    {
        return new Document((new Resource($persistenceUnitViewData, new PersistenceUnitSerializer()))->with('datasource'));
    }

    /**
     * Convert's the passed persistence unit DTOs into a JSON-API document representation.
     *
     * @param \AppserverIo\Collections\CollectionInterface $persistenceUnits The persistence unit DTOs to convert
     *
     * @return Tobscure\JsonApi\Document The JSON-API document representation
     */
    public function toPersistenceUnitOverviewData(CollectionInterface $persistenceUnits)
    {

        // create a new collection of naming directories
        $collection = new Collection($persistenceUnits, new PersistenceUnitSerializer());

        // create a new JSON-API document with that collection as the data
        $document = new Document($collection);

        // add metadata and links
        $document->addMeta('total', $persistenceUnits->size());

        // return the stdClass representation of the naming directories
        return $document;
    }

    /**
     * Returns the a new JSON-API document with the persistence unit node data.
     *
     * @param string $id The unique ID of the persistence unit node to load
     *
     * @return \Tobscure\JsonApi\Document The document representation of the persistence unit node
     * @see \AppserverIo\Apps\Api\Assembler\PersistenceUnitAssemblerInterface::getPersistenceUnitViewData()
     */
    public function getPersistenceUnitViewData($id)
    {
        return $this->toPersistenceUnitViewData($this->getPersistenceUnitTransferObjectAssembler()->getPersistenceUnitViewData($id));
    }

    /**
     * Returns the a new JSON-API document with the persistence unit node array as the data.
     *
     * @return Tobscure\JsonApi\Document The document representation of the persistence unit nodes
     * @see \AppserverIo\Apps\Api\Assembler\PersistenceUnitAssemblerInterface::getPersistenceUnitOverviewData()
     */
    public function getPersistenceUnitOverviewData()
    {
        return $this->toPersistenceUnitOverviewData($this->getPersistenceUnitTransferObjectAssembler()->getPersistenceUnitOverviewData());
    }
}
