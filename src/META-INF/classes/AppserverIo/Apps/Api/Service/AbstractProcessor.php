<?php

/**
 * AppserverIo\Apps\Api\Service\AbstractProcessor
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

use AppserverIo\Psr\Application\ApplicationInterface;

/**
 * An abstract SLSB implementation providing the basic business logic to handle requests.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
abstract class AbstractProcessor
{

    /**
     * The application instance that provides the entity manager.
     *
     * @var \AppserverIo\Psr\Application\ApplicationInterface
     * @Resource(name="ApplicationInterface")
     */
    protected $application;

    /**
     * Return's the application instance.
     *
     * @return \AppserverIo\Psr\Application\ApplicationInterface
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Return's The naming directory instance.
     *
     * @return \AppserverIo\Psr\Naming\NamingDirectoryInterface The naming directory instance
     */
    public function getNamingDirectory()
    {
        return $this->getApplication()->getNamingDirectory();
    }

    /**
     * Returns the initial context instance.
     *
     * @return \AppserverIo\Appserver\Core\InitialContext The initial context instance
     */
    public function getInitialContext()
    {
        return $this->getApplication()->getInitialContext();
    }

    /**
     * Creates a new instance of the passed service class name
     * and returns it.
     *
     * @param string $serviceClass The service class name to return the instance for
     *
     * @return \AppserverIo\AppServer\Core\Api\ServiceInterface The service class instance
     */
    public function newService($serviceClass)
    {
        return $this->getApplication()->newService($serviceClass);
    }
}
