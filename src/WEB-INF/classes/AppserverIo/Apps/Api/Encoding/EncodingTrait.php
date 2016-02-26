<?php

/**
 * AppserverIo\Apps\Api\Encoding\EncodingTrait
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

namespace AppserverIo\Apps\Api\Encoding;

use AppserverIo\Http\HttpProtocol;
use AppserverIo\Apps\Api\Utils\RequestKeys;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;

/**
 * The trait that provides basic encoding functionality.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
trait EncodingTrait
{

    /**
     * The encoding handler used to encode the result data.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Encoding\EncodingHandlerInterface
     * @EnterpriseBean
     */
    protected $encodingHandler;

    /**
     * Returns the encoding handler instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Encoding\EncodingHandlerInterface
     */
    public function getEncodingHandler()
    {
        return $this->encodingHandler;
    }

    /**
     * Encodes the request using the configured encoding method, e. g. JSON.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     */
    public function encode(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // load the servlet response status code
        $statusCode = $servletResponse->getStatusCode();

        // load the result to be encoded, but only if we've NO redirect response (response code 300 - 399)
        if (($statusCode < 299 || $statusCode > 399) && $result = $servletRequest->getAttribute(RequestKeys::RESULT)) {
            // encode the result with the configured encoder
            $viewData = $this->getEncodingHandler()->encode($result);

            // add the header for the content type and append the encoded content
            $servletResponse->addHeader(HttpProtocol::HEADER_CONTENT_TYPE, $viewData->getContentType());
            $servletResponse->appendBodyStream($viewData->getData());
        }
    }
}
