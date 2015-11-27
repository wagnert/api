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
use \Doctrine\ORM\EntityManagerInterface;
use AppserverIo\Apps\Api\Serializer\PersistenceUnitSerializer;
use AppserverIo\Apps\Api\Assembler\PersistenceUnitAssemblerInterface;

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
 * @Stateless
 */
class PersistenceUnitAssembler implements PersistenceUnitAssemblerInterface
{

    /**
     * Returns the a new JSON-API document with the persistence unit data.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $persistenceUnit The persistence unit to assemble
     *
     * @return \Tobscure\JsonApi\Document The document representation of the persistence unit
     * @see \AppserverIo\Apps\Api\Assembler\PersistenceUnitAssemblerInterface::getPersistenceUnitViewData()
     */
    public function getPersistenceUnitViewData(EntityManagerInterface $persistenceUnit)
    {
        return new Document(new Resource($persistenceUnit, new PersistenceUnitSerializer()));
    }

    /**
     * Returns the a new JSON-API document with the persistence unit array as the data.
     *
     * @param array $entityManagers The array with the persistence units to assemble
     *
     * @return \Tobscure\JsonApi\Document The document representation of the persistence units
     * @see \AppserverIo\Apps\Api\Assembler\PersistenceUnitAssemblerInterface::getPersistenceUnitOverviewData()
     */
    public function getPersistenceUnitOverviewData(array $entityManagers)
    {

        // create a new collection of naming directories
        $collection = new Collection($entityManagers, new PersistenceUnitSerializer());

        // create a new JSON-API document with that collection as the data
        $document = new Document($collection);

        // add metadata and links
        $document->addMeta('total', count($entityManagers));

        // return the stdClass representation of the naming directories
        return $document;
    }
}
