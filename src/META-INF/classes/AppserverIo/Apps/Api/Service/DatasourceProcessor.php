<?php

/**
 * AppserverIo\Apps\Api\Service\DatasourceProcessor
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

namespace AppserverIo\Apps\Api\Service;

use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Collection;
use AppserverIo\Psr\Naming\NamingDirectoryInterface;
use AppserverIo\Psr\Application\ApplicationInterface;
use AppserverIo\Appserver\Core\Api\Node\DatasourceNode;
use AppserverIo\Apps\Api\Serializer\DatasourceSerializer;

/**
 * A SLSB implementation providing the business logic to handle datasources.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class DatasourceProcessor implements DatasourceProcessorInterface
{

    /**
     * The application instance that provides the entity manager.
     *
     * @var \AppserverIo\Psr\Application\ApplicationInterface
     * @Resource(name="ApplicationInterface")
     */
    protected $application;

    /**
     * Initializes the stdClass representation of the datasource with
     * the ID passed as parameter.
     *
     * @param string $id The ID of the requested datasource
     *
     * @return \stdClass The datasource as \stdClass representation
     */
    public function load($id)
    {
    }

    /**
     * Returns an stdClass representation of all datasources.
     *
     * @return Tobscure\JsonApi\Document A document representation of the datasources
     */
    public function findAll()
    {

        // create a local naming directory instance
        $namingDirectory = $this->application->getNamingDirectory();

        // initialize the array with the datasources
        $datasources = array();

        // convert the application nodes into stdClass representation
        foreach ($namingDirectory->search('php:env')->getAllKeys() as $key) {
            try {

                $val = $namingDirectory->search(sprintf('php:env/%s/ds', $key));

                if ($val instanceof NamingDirectoryInterface) {

                    // try to load the application
                    foreach ($val->getAllKeys() as $dsKey) {

                        // try to load the datasource
                        $value = $namingDirectory->search(sprintf('php:env/%s/ds/%s', $key, $dsKey));

                        // query whether we've found a datasource instance or not
                        if ($value instanceof DatasourceNode) {
                            $datasources[] = $value;
                        }
                    }
                }

            } catch (\Exception $e) {
                // do nothing here, because
            }
        }

        // create a new collection of datasources
        $collection = (new Collection($datasources, new DatasourceSerializer()))->with(['database']);

        // create a new JSON-API document with that collection as the data
        $document = new Document($collection);

        // add metadata and links.
        $document->addMeta('total', count($datasources));
        $document->addLink('self', 'http://localhost:9080/api/datasources.do');

        // return the stdClass representation of the datasources
        return $document;
    }
}
