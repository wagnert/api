<?php

/**
 * AppserverIo\Apps\Api\Assembler\JsonApi\ApplicationAssembler
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
use AppserverIo\Psr\Application\ApplicationInterface;
use AppserverIo\Apps\Api\Assembler\ApplicationAssemblerInterface;
use AppserverIo\Apps\Api\Assembler\JsonApi\Serializer\ApplicationSerializer;
use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;

/**
 * A SLSB implementation providing the business logic to assemble applications
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
class ApplicationAssembler implements ApplicationAssemblerInterface
{

    /**
     * The application repository instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Assembler\ApplicationAssemblerInterface
     * @EPB\EnterpriseBean
     */
    protected $applicationTransferObjectAssembler;

    /**
     * Return's the assembler instance.
     *
     * @return AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Assembler\ApplicationAssemblerInterface
     */
    protected function getApplicationTransferObjectAssembler()
    {
        return $this->applicationTransferObjectAssembler;
    }

    /**
     * Convert's the passed DTO into a JSON-API document representation.
     *
     * @param \AppserverIo\Apps\Api\TransferObject\ApplicationViewData $applicationViewData The DTO to convert
     *
     * @return Tobscure\JsonApi\Document The JSON-API document representation
     */
    protected function toApplicationViewData($applicationViewData)
    {
        return new Document(new Resource($applicationViewData, new ApplicationSerializer()));
    }

    /**
     * Convert's the passed DTOs into a JSON-API document representation.
     *
     * @param \AppserverIo\Collections\CollectionInterface $applications The application DTOs to convert
     *
     * @return Tobscure\JsonApi\Document The JSON-API document representation
     */
    protected function toApplicationOverviewData(CollectionInterface $applications)
    {

        // create a new collection of naming directories
        $collection = new Collection($applications->toArray(), new ApplicationSerializer());

        // create a new JSON-API document with that collection as the data
        $document = new Document($collection);

        // add metadata and links
        $document->addMeta('total', count($applications));

        // return the JSON-API representation
        return $document;
    }

    /**
     * Returns the a new JSON-API document with the application data.
     *
     * @param string $id The unique ID of the virtual host to load
     *
     * @return \Tobscure\JsonApi\Document The document representation of the application
     * @see \AppserverIo\Apps\Api\Assembler\ApplicationAssemblerInterface::getApplicationViewData()
     */
    public function getApplicationViewData($id)
    {
        return $this->toApplicationViewData($this->getApplicationTransferObjectAssembler()->getApplicationViewData($id));
    }

    /**
     * Returns the a new JSON-API document with the application array as the data.
     *
     * @return Tobscure\JsonApi\Document The document representation of the applications
     * @see \AppserverIo\Apps\Api\Assembler\ApplicationAssemblerInterface::getApplicationOverviewData()
     */
    public function getApplicationOverviewData()
    {
        return $this->toApplicationOverviewData($this->getApplicationTransferObjectAssembler()->getApplicationOverviewData());
    }
}
