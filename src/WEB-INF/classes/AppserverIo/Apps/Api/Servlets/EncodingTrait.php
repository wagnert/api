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

use AppserverIo\Http\HttpProtocol;
use AppserverIo\Apps\Api\Utils\RequestKeys;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;

/**
 * The abstract servlet implementation that provides basic encoding functionality.
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
     * The encoder used to encode the result data.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Encoder\EncoderInterface
     * @EnterpriseBean(beanName="JmsSerializerEncoder")
     */
    protected $encoder;

    /**
     * Returns the encoder instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Encoder\EncoderInterface
     */
    public function getEncoder()
    {
        return $this->encoder;
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

        // add the header for the content type
        $servletResponse->addHeader(HttpProtocol::HEADER_CONTENT_TYPE, $this->getEncoder()->getContentType());

        // append the encoded content to the servlet response
        $servletResponse->appendBodyStream($this->getEncoder()->encode($servletRequest->getAttribute(RequestKeys::RESULT)));
    }
}
