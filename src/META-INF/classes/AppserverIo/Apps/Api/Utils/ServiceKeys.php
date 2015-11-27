<?php

/**
 * AppserverIo\Apps\Api\Utils\RequestKeys
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

namespace AppserverIo\Apps\Api\Utils;

/**
 * Provides keys with the available service names.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
class ServiceKeys
{

    /**
     * Private to constructor to avoid instancing this class.
     */
    private function __construct()
    {
    }

    /**
     * The class name of the application service.
     *
     * @return string
     */
    const APPLICATION = 'AppserverIo\Appserver\Core\Api\AppService';

    /**
     * The class name of the container service.
     *
     * @return string
     */
    const CONTAINER = 'AppserverIo\Appserver\Core\Api\ContainerService';

    /**
     * The class name of the virual host service.
     *
     * @return string
     */
    const VIRTUAL_HOST = 'AppserverIo\Appserver\Core\Api\VirtualHostService';
}
