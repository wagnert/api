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
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Apps\Api\Servlets;

use AppserverIo\Apps\Api\Utils\RequestKeys;
use AppserverIo\Apps\Api\Encoding\EncodingAwareInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;

/**
 * Servlet that handles all app related requests.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Route(name="datasources",
 *        displayName="Handles datasource related requests",
 *        description="A servlet implementation that handles all datasource related requests.",
 *        urlPattern={"/datasources.do", "/datasources.do*"})
 */
class DatasourceServlet extends AbstractServlet implements EncodingAwareInterface
{

    /**
     * The datasource processor instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @var \AppserverIo\Apps\Api\Services\DatasourceProcessorInterface
     * @EnterpriseBean
     */
    protected $datasourceProcessor;

    /**
     * Return's the datasource processor instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The processor proxy
     * @see \AppserverIo\Apps\Api\Services\DatasourceProcessorInterface
     */
    public function getDatasourceProcessor()
    {
        return $this->datasourceProcessor;
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
     *   tags={"datasources"},
     *   summary="List's all datasources",
     *   @SWG\Response(
     *     response=200,
     *     description="A list with the available datasources",
     *     @SWG\Schema(
     *       type="array",
     *       @SWG\Items(ref="#/definitions/DatasourceOverviewData")
     *     )
     *   ),
     *   @SWG\Response(
     *     response=500,
     *     description="Internal Server Error"
     *   )
     * )
     *
     * @SWG\Get(
     *   path="/datasources.do/{id}",
     *   tags={"datasources"},
     *   summary="Load's the datasource with the passed ID",
     *   @SWG\Parameter(
     *      name="id",
     *      in="path",
     *      description="The name of the datasource to load",
     *      required=true,
     *      type="string"
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="The requested datasource",
     *     @SWG\Schema(
     *       ref="#/definitions/DatasourceViewData"
     *     )
     *   ),
     *   @SWG\Response(
     *     response=500,
     *     description="Internal Server Error"
     *   )
     * )
     */
    public function doGet(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // load the requested path info, e. g. /api/datasources.do/appserver.io-example/
        $pathInfo = trim($servletRequest->getPathInfo(), '/');

        // extract the entity and the ID, if available
        list ($id, ) = explode('/', $pathInfo);

        // query whether we've found an ID or not
        if ($id == null) {
            $content = $this->getDatasourceProcessor()->findAll();
        } else {
            $content = $this->getDatasourceProcessor()->load($id);
        }

        // add the result to the request
        $servletRequest->setAttribute(RequestKeys::RESULT, $content);
    }
}
