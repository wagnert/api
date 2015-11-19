<?php

/**
 * AppserverIo\Apps\Api\Service\ApplicationProcessor
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
use AppserverIo\Psr\Application\ApplicationInterface;
use AppserverIo\Apps\Api\Serializer\ApplicationSerializer;

/**
 * A SLSB implementation providing the business logic to handle applications.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class ApplicationProcessor implements ApplicationProcessorInterface
{

    /**
     * The application instance that provides the entity manager.
     *
     * @var \AppserverIo\Psr\Application\ApplicationInterface
     * @Resource(name="ApplicationInterface")
     */
    protected $application;

    /**
     * Initializes the stdClass representation of the application with
     * the ID passed as parameter.
     *
     * @param string $id The ID of the requested application
     *
     * @return \stdClass The application as \stdClass representation
     */
    public function load($id)
    {
    }

    /**
     * Returns an stdClass representation of all applications.
     *
     * @return Tobscure\JsonApi\Document A document representation of the applications
     */
    public function findAll()
    {

        // create a local naming directory instance
        $namingDirectory = $this->application->getNamingDirectory();

        $applications = array();

        // convert the application nodes into stdClass representation
        foreach ($namingDirectory->search('php:global')->getAllKeys() as $key) {
            try {
                // try to load the application
                $value = $namingDirectory->search(sprintf('php:global/%s/env/ApplicationInterface', $key));

                // query whether we've found an application instance or not
                if ($value instanceof ApplicationInterface) {
                    $applications[] = $value;
                }

            } catch (\Exception $e) {
                // do nothing here, because
            }
        }

        // create a new collection of applications, and specify relationships to be included
        $collection = new Collection($applications, new ApplicationSerializer());

        // create a new JSON-API document with that collection as the data
        $document = new Document($collection);

        // add metadata and links.
        $document->addMeta('total', count($applications));
        $document->addLink('self', 'http://example.com/api/posts');

        // return the stdClass representation of the apps
        return $document;
    }
}
