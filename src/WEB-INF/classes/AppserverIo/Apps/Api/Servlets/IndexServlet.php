<?php

/**
 * AppserverIo\Apps\Api\Servlets\IndexServlet
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

namespace AppserverIo\Apps\Api\Servlets;

use AppserverIo\Apps\Api\Utils\RequestKeys;
use AppserverIo\Apps\Api\Encoding\EncodingAwareInterface;
use AppserverIo\Apps\Api\Validation\ValidationAwareInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;
use AppserverIo\Psr\Servlet\Annotations as SRV;
use Swagger\Annotations as SWG;

/**
 * Servlet to handle a simple welcome page request.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @SRV\Route(name="index",
 *        displayName="Handles API information requests",
 *        description="A servlet implementation that handles API information requests.",
 *        urlPattern={"/index.do", "/index.do*"})
 *
 * @SWG\Info(
 *   title="Internal appserver.io API",
 *   version="0.1",
 *   contact={"name":"Tim Wagner", "url":"http://www.appserver.io", "email":"tw@appserver.io"},
 *   license={"name":"OSL 3.0", "url"="http://opensource.org/licenses/osl-3.0.php"}
 * )
 *
 * @SWG\Swagger(
 *   schemes={"http", "https"},
 *   host="127.0.0.1:9024",
 *   basePath="/api",
 *   produces={"application/json"},
 *   swagger="2.0"
 * )
 */
class IndexServlet extends AbstractServlet implements EncodingAwareInterface, ValidationAwareInterface
{

    /**
     * Returns a simple welcome page.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doGet()
     *
     * @SWG\Get(
     *   path="/index.do",
     *   summary="Welcome Page",
     *   tags={"index"},
     *   @SWG\Response(
     *     response=200,
     *     description="A simple welcome page"
     *   ),
     *   @SWG\Response(
     *     response=500,
     *     description="Internal Server Error"
     *   )
     * )
     */
    public function doGet(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {
        $servletRequest->setAttribute(RequestKeys::RESULT, array('Welcome to appserver.io API'));
    }
}
