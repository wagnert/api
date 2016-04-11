<?php

/**
 * AppserverIo\Apps\Api\Validation\ValidationTrait
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

use AppserverIo\Http\HttpProtocol;
use AppserverIo\Apps\Api\Utils\RequestKeys;
use AppserverIo\Apps\Api\TransferObject\ErrorOverviewData;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;

/**
 * Trait that provides validation functionality and error handling.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
trait ValidationTrait
{

    /**
     * The error handler to convert the errors into the expected structure.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Errors\ErrorInterface
     * @EnterpriseBean(beanName="ErrorHandler")
     */
    protected $errorHandler;

    /**
     * The array containing the servlet's errors.
     *
     * @var array
     */
    protected $errors = array();

    /**
     * Return's the error handler instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Errors\ErrorHandlerInterface
     */
    public function getErrorHandler()
    {
        return $this->errorHandler;
    }

    /**
     * Add's the passed error to the servlet.
     *
     * @param  $error The exception containing the error information
     *
     * @return void
     */
    public function addError($error)
    {
        $this->errors[] = $error;
    }

    /**
     * Return's the servlet's errors.
     *
     * @return array The errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Query's whether errors has occured when the servlet has been processed.
     *
     * @return boolean TRUE if the servlet has errors, else FALSE
     */
    public function hasErrors()
    {
        return sizeof($this->errors) > 0;
    }

    /**
     * Processes the servlet's errors.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     */
    public function processErrors(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // add the transfer object containing the errors as requeset attribute
        $servletRequest->setAttribute(RequestKeys::RESULT, $to = $this->getErrorHandler()->processErrors($this->getErrors()));

        // sort the errors ascending to load the most generally applicable HTTP error code
        usort($errors = $to->getErrors(), function (ErrorOverviewData $e1, ErrorOverviewData $e2) {
            // compare the status codes
            if ($e1->getStatus() > $e2->getStatus()) {
                return 1;
            }
            if ($e1->getStatus() < $e2->getStatus()) {
                return -1;
            }
            return 0;
        });

        // set the most generally applicable HTTP error code
        foreach ($errors as $error) {
            $servletResponse->setStatusCode($error->getStatus());
            break;
        }
    }
}
