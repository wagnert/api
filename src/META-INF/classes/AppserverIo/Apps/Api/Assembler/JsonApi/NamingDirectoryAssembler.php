<?php

/**
 * AppserverIo\Apps\Api\Assembler\JsonApi\NamingDirectoryAssembler
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
use AppserverIo\Psr\NamingDirectory\NamingDirectoryInterface;
use AppserverIo\Apps\Api\Assembler\NamingDirectoryAssemblerInterface;
use AppserverIo\Apps\Api\Assembler\JsonApi\Serializer\NamingDirectoryViewSerializer;
use AppserverIo\Apps\Api\Assembler\JsonApi\Serializer\NamingDirectoryOverviewSerializer;
use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;

/**
 * A SLSB implementation providing the business logic to assemble naming directories
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
class NamingDirectoryAssembler implements NamingDirectoryAssemblerInterface
{

    /**
     * The naming directory DTO assembler instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Assembler\NamingDirectoryAssemblerInterface
     *
     * @EPB\EnterpriseBean
     */
    protected $namingDirectoryTransferObjectAssembler;

    /**
     * Return's the assembler instance.
     *
     * @return AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Assembler\NamingDirectoryAssemblerInterface
     */
    protected function getNamingDirectoryTransferObjectAssembler()
    {
        return $this->namingDirectoryTransferObjectAssembler;
    }

    /**
     * Convert's the passed DTO into a JSON-API document representation.
     *
     * @param \AppserverIo\Apps\Api\TransferObject\NamingDirectoryViewData $namingDirectoryViewData The datasource DTO to convert
     *
     * @return Tobscure\JsonApi\Document The JSON-API document representation
     */
    protected function toNamingDirectoryViewData($namingDirectoryViewData)
    {
        return new Document(new Resource($namingDirectoryViewData, new NamingDirectoryViewSerializer()));
    }

    /**
     * Convert's the passed naming directory DTOs into a JSON-API document representation.
     *
     * @param \AppserverIo\Collections\CollectionInterface $namingDirectories The naming directory DTOs to convert
     *
     * @return Tobscure\JsonApi\Document The JSON-API document representation
     */
    protected function toNamingDirectoryOverviewData(CollectionInterface $namingDirectories)
    {

        // create a new collection of naming directories
        $collection = new Collection($namingDirectories->toArray(), new NamingDirectoryOverviewSerializer());

        // create a new JSON-API document with that collection as the data
        $document = new Document($collection);

        // add metadata and links
        $document->addMeta('total', count($namingDirectories));

        // return the JSON-API representation
        return $document;
    }

    /**
     * Returns the a new JSON-API document with the naming directory data.
     *
     * @param string $id The unique ID of the naming directory to load
     *
     * @return \Tobscure\JsonApi\Document The document representation of the naming directory
     * @see \AppserverIo\Apps\Api\Assembler\NamingDirectoryAssemblerInterface::getNamingDirectoryViewData()
     */
    public function getNamingDirectoryViewData($id)
    {
        return $this->toNamingDirectoryViewData($this->getNamingDirectoryTransferObjectAssembler()->getNamingDirectoryViewData($id));
    }

    /**
     * Returns the a new JSON-API document with the naming directory array as the data.
     *
     * @return Tobscure\JsonApi\Document The document representation of the naming directories
     * @see \AppserverIo\Apps\Api\Assembler\NamingDirectoryAssemblerInterface::getNamingDirectoryOverviewData()
     */
    public function getNamingDirectoryOverviewData()
    {
        return $this->toNamingDirectoryOverviewData($this->getNamingDirectoryTransferObjectAssembler()->getNamingDirectoryOverviewData());
    }
}
