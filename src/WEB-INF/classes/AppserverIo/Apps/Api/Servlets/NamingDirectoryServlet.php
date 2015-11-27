<?php

/**
 * AppserverIo\Apps\Api\Servlets\NamingDirectoryServlet
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
use AppserverIo\Psr\Servlet\ServletConfig;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;

/**
 * Servlet that handles all container related requests.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 *
 * @SWG\Info(title="My First API", version="0.1")
 *
 * @SWG\Swagger(
 *   schemes={"http"},
 *   host="localhost:9080",
 *   basePath="/api"
 * )
 */
class NamingDirectoryServlet extends AbstractServlet
{

    /**
     * The NamingDirectoryProcessor instance.
     *
     * @var \AppserverIo\Apps\Api\Services\NamingDirectoryProcessor
     * @EnterpriseBean
     */
    protected $namingDirectoryProcessor;

    /**
     * Returns the servlets service class to use.
     *
     * @return string The servlets service class
     */
    public function getServiceClass()
    {
    }

    /**
     * Tries to load the content of the naming directory and adds it to the response.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doGet()
     *
     * @SWG\Get(
     *   path="/namingDirectories.do",
     *   summary="list the content of the naming directory",
     *   @SWG\Response(
     *     response=200,
     *     description="The naming directory content"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function doGet(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // query whether we've found an ID or not
        $content = $this->namingDirectoryProcessor->load();

        // set the JSON encoded data in the response
        $servletResponse->addHeader(HttpProtocol::HEADER_CONTENT_TYPE, 'application/json');
        $servletResponse->addHeader('Access-Control-Allow-Origin', '*');
        $servletResponse->addHeader('Access-Control-Allow-Methods', 'GET, POST, DELETE, PUT, PATCH, OPTIONS');
        $servletResponse->addHeader('Access-Control-Allow-Headers', 'Content-Type, api_key, Authorization');

        // return the JSON encoded response
        $servletResponse->appendBodyStream(json_encode($content));
    }
}
