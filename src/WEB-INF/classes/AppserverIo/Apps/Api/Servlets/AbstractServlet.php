<?php

/**
 * AppserverIo\Apps\Api\Servlets\AbstractServlet
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
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Apps\Api\Servlets;

use AppserverIo\Psr\Servlet\Http\HttpServlet;
use AppserverIo\Apps\Api\Encoding\EncodingTrait;
use AppserverIo\Apps\Api\Validation\ValidationTrait;
use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;

/**
 * The abstract servlet implementation that provides basic helper functionality.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
abstract class AbstractServlet extends HttpServlet
{

    /**
     * Trait that provides validation handling functionality.
     *
     * @var \AppserverIo\Apps\Api\Validation\ValidationTrait
     */
    use ValidationTrait;

    /**
     * Trait that provides encoding functionality.
     *
     * @var \AppserverIo\Apps\Api\Encoding\EncodingTrait
     */
    use EncodingTrait;

    /**
     * The system logger implementation.
     *
     * @var \AppserverIo\Logger\Logger
     * @EPB\Resource(lookup="php:global/log/System")
     */
    protected $systemLogger;

    /**
     * Return's the system logger instance.
     *
     * @return \AppserverIo\Logger\Logger The logger instance
     */
    protected function getSystemLogger()
    {
        return $this->systemLogger;
    }
}
