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
use AppserverIo\Psr\Application\ApplicationInterface;
use AppserverIo\Apps\Api\Serializer\ApplicationSerializer;
use AppserverIo\Apps\Api\Assembler\ApplicationAssemblerInterface;

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
 * @Stateless
 */
class ApplicationAssembler implements ApplicationAssemblerInterface
{

    /**
     * Returns the a new JSON-API document with the application data.
     *
     * @param \AppserverIo\Psr\Application\ApplicationInterface $application The application to assemble
     *
     * @return \Tobscure\JsonApi\Document The document representation of the application
     * @see \AppserverIo\Apps\Api\Assembler\ApplicationAssemblerInterface::getApplicationViewData()
     */
    public function getApplicationViewData(ApplicationInterface $application)
    {
        return new Document((new Resource($application, new ApplicationSerializer()))->with(['persistenceUnits']));
    }

    /**
     * Returns the a new JSON-API document with the application array as the data.
     *
     * @param array $applications The array with the applications to assemble
     *
     * @return Tobscure\JsonApi\Document The document representation of the applications
     * @see \AppserverIo\Apps\Api\Assembler\ApplicationAssemblerInterface::getApplicationOverviewData()
     */
    public function getApplicationOverviewData(array $applications)
    {

        // create a new collection of applications, and specify relationships to be included
        $collection = (new Collection($applications, new ApplicationSerializer()))->with(['persistenceUnits']);

        // create a new JSON-API document with that collection as the data
        $document = new Document($collection);

        // add metadata and links.
        $document->addMeta('total', count($applications));

        // return the stdClass representation of the apps
        return $document;
    }
}
