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
use AppserverIo\Psr\Servlet\Http\HttpServlet;
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
 */
class NamingDirectoryServlet extends HttpServlet
{

    /**
     * The NamingDirectoryProcessor instance.
     *
     * @var \AppserverIo\Apps\Api\Services\NamingDirectoryProcessor
     * @EnterpriseBean
     */
    protected $namingDirectoryProcessor;

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
     *   tags={"namingDirectories"},
     *   summary="List's the available naming directories",
     *   @SWG\Response(
     *     response=200,
     *     description="A list with the available naming directories",
     *     @SWG\Schema(
     *       type="array",
     *       @SWG\Items(ref="#/definitions/NamingDirectoryOverviewData")
     *     )
     *   ),
     *   @SWG\Response(
     *     response=500,
     *     description="Internal Server Error"
     *   )
     * )
     *
     * @SWG\Get(
     *   path="/namingDirectories.do/{id}",
     *   tags={"namingDirectories"},
     *   summary="Load's the naming directory with the passed ID",
     *   @SWG\Parameter(
     *      name="id",
     *      in="path",
     *      description="The UUID of the naming directory to load",
     *      required=true,
     *      type="string"
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="The requested naming directory",
     *     @SWG\Schema(
     *       ref="#/definitions/NamingDirectoryViewData"
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

        // load the requested path info, e. g. /api/namingDirectories.do/5e83e3e6-b1d5-49de-92ae-7fca480593b8
        $pathInfo = trim($servletRequest->getPathInfo(), '/');

        // extract the entity and the ID, if available
        list (, $id) = explode('/', $pathInfo);

        // query whether we've found an ID or not
        if ($id == null) {
            $content = $this->namingDirectoryProcessor->findAll();
        } else {
            $content = $this->namingDirectoryProcessor->load($id);
        }

        // return the JSON encoded response
        $servletResponse->appendBodyStream(json_encode($content));
    }
}
