<?php

/**
 * AppserverIo\Apps\Api\Servlets\DatasourceServlet
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

use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;
use AppserverIo\Http\HttpProtocol;

/**
 * Servlet that handles all app related requests.
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
class DatasourceServlet extends AbstractServlet
{

    /**
     * The DatasourceProcessor instance.
     *
     * @var \AppserverIo\Apps\Api\Services\DatasourceProcessor
     * @EnterpriseBean
     */
    protected $datasourceProcessor;

    /**
     * Returns the servlets service class to use.
     *
     * @return string The servlets service class
     */
    public function getServiceClass()
    {
    }

    /**
     * Tries to load the requested datasources and adds them to the response.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doGet()
     *
     * @SWG\Get(
     *   path="/datasources.do",
     *   summary="list datasources",
     *   @SWG\Response(
     *     response=200,
     *     description="A list with deployed datasources"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function doGet(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // load the requested path info, e. g. /api/datasources.do/appserver.io-example/
        $pathInfo = trim($servletRequest->getPathInfo(), '/');

        // extract the entity and the ID, if available
        list ($entity, $id) = explode('/', $pathInfo);

        // query whether we've found an ID or not
        if ($id == null) {
            $content = $this->datasourceProcessor->findAll();
        } else {
            $content = $this->datasourceProcessor->load($id);
        }

        // set the JSON encoded data in the response
        $servletResponse->addHeader(HttpProtocol::HEADER_CONTENT_TYPE, 'application/vnd.api+json');
        $servletResponse->addHeader('Access-Control-Allow-Origin', '*');
        $servletResponse->addHeader('Access-Control-Allow-Methods', 'GET, POST, DELETE, PUT, PATCH, OPTIONS');
        $servletResponse->addHeader('Access-Control-Allow-Headers', 'Content-Type, api_key, Authorization');

        // return the JSON encoded response
        $servletResponse->appendBodyStream(json_encode($content));
    }

    /**
     * Creates a new datasource.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doPost()
     *
     * @SWG\Post(
     *   path="/datasources.do",
     *   summary="creates a new datasource",
     *   @SWG\Response(
     *     response=200,
     *     description="a ""success"" message"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function doPost(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {
    }

    /**
     * Updates the datasource with the passed content.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doPut()
     *
     * @SWG\Put(
     *   path="/datasources.do",
     *   summary="updates an existing datasource",
     *   @SWG\Response(
     *     response=200,
     *     description="a ""success"" message"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function doPut(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {
    }

    /**
     * Delete the requested datasource.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doDelete()
     *
     * @SWG\Delete(
     *   path="/applications.do",
     *   summary="deletes an existing datasource",
     *   @SWG\Response(
     *     response=200,
     *     description="a ""success"" message"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function doDelete(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {
    }
}
