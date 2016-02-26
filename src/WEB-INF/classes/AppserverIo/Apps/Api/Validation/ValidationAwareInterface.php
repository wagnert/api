<?php

/**
 * AppserverIo\Apps\Api\Validation\ValidationAwareInterface
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

namespace AppserverIo\Apps\Api\Validation;

use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;

/**
 * Interface for validation aware servlets.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
interface ValidationAwareInterface
{

    /**
     * Queries whether errors has occured when the servlet has been processed.
     *
     * @return boolean TRUE if the servlet has errors, else FALSE
     */
    public function hasErrors();

    /**
     * Return's the servlet's errors.
     *
     * @return array The errors
     */
    public function getErrors();

    /**
     * Add's the passed error to the servlet.
     *
     * @param  $error The exception containing the error information
     *
     * @return void
     */
    public function addError($error);

    /**
     * Processes the servlets errors.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     */
    public function processErrors(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse);
}
