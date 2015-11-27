<?php

/**
 * AppserverIo\Apps\Api\Servlets\VirtualHostServlet
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
use AppserverIo\Psr\Servlet\Http\HttpServlet;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;

/**
 * Servlet that handles all vhost related requests.
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
class VirtualHostServlet extends HttpServlet
{

    /**
     * The VirtualHostProcessor instance.
     *
     * @var \AppserverIo\Apps\Api\Services\VirtualHostProcessor
     * @EnterpriseBean
     */
    protected $virtualHostProcessor;

    /**
     * Tries to load the requested vhosts and adds them to the response.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doGet()
     *
     * @SWG\Get(
     *   path="/applications.do",
     *   summary="list applications",
     *   @SWG\Response(
     *     response=200,
     *     description="A list with deployed apps"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function doGet(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // load the requested path info, e. g. /api/applications.do/example/
        $pathInfo = trim($servletRequest->getPathInfo(), '/');

        // extract the entity and the ID, if available
        list (, $id) = explode('/', $pathInfo);

        // query whether we've found an ID or not
        if ($id == null) {
            $content = $this->virtualHostProcessor->findAll();
        } else {
            $content = $this->virtualHostProcessor->load($id);
        }

        // set the JSON encoded data in the response
        $servletResponse->addHeader(HttpProtocol::HEADER_CONTENT_TYPE, 'application/json');
        $servletResponse->addHeader('Access-Control-Allow-Origin', '*');
        $servletResponse->addHeader('Access-Control-Allow-Methods', 'GET, POST, DELETE, PUT, PATCH, OPTIONS');
        $servletResponse->addHeader('Access-Control-Allow-Headers', 'Content-Type, api_key, Authorization');

        // return the JSON encoded response
        $servletResponse->appendBodyStream(json_encode($content));
    }
}
