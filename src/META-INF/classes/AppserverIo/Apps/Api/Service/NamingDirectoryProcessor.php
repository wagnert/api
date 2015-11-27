<?php

/**
 * AppserverIo\Apps\Api\Service\NamingDirectoryProcessor
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
use Tobscure\JsonApi\Resource;
use AppserverIo\Apps\Api\Serializer\NamingDirectorySerializer;

/**
 * A SLSB implementation providing the business logic to handle naming directories.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class NamingDirectoryProcessor implements NamingDirectoryProcessorInterface
{

    /**
     * The application instance that provides access to the naming directory.
     *
     * @var \AppserverIo\Psr\Application\ApplicationInterface
     * @Resource(name="ApplicationInterface")
     */
    protected $application;

    /**
     * Initializes the stdClass representation of the naming directory with
     * the ID passed as parameter.
     *
     * @return \Tobscure\JsonApi\Document The naming directory representation
     */
    public function load()
    {

        // create a local naming directory instance
        $namingDirectory = $this->application->getNamingDirectory();

        // create a new JSON-API document with that collection as the data
        $document = new Document(new Resource($namingDirectory, new NamingDirectorySerializer()));

        // add metadata and links
        $document->addLink('self', 'http://localhost:9080/api/namingDirectories.do');

        // serialize and return the naming directory
        return $document;
    }
}
