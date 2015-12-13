<?php

/**
 * AppserverIo\Apps\Api\Servlets\ApplicationServlet
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

use AppserverIo\Psr\Servlet\Http\HttpServlet;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;

/**
 * Servlet that handles all app related requests.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class ApplicationServlet extends HttpServlet
{

    /**
     * Filename of the uploaded file with the webapp PHAR.
     *
     * @var string
     */
    const UPLOADED_PHAR_FILE = 'file';

    /**
     * The ApplicationProcessor instance.
     *
     * @var \AppserverIo\Apps\Api\Services\ApplicationProcessor
     * @EnterpriseBean
     */
    protected $applicationProcessor;

    /**
     * Tries to load the requested applications and adds them to the response.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doGet()
     *
     * @SWG\Get(
     *   path="/applications.do",
     *   tags={"applications"},
     *   summary="List's all applications",
     *   @SWG\Response(
     *     response=200,
     *     description="A list with the available applications",
     *     @SWG\Schema(
     *       type="array",
     *       @SWG\Items(ref="#/definitions/ApplicationOverviewData")
     *     )
     *   ),
     *   @SWG\Response(
     *     response="500",
     *     description="Internal Server Error"
     *   )
     * )
     *
     * @SWG\Get(
     *   path="/applications.do/{id}",
     *   tags={"applications"},
     *   summary="Load's the application with the passed ID",
     *   @SWG\Parameter(
     *      name="id",
     *      in="path",
     *      description="The name of the application to load",
     *      required=true,
     *      type="string"
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="The requested application",
     *     @SWG\Schema(
     *       ref="#/definitions/ApplicationViewData"
     *     )
     *   ),
     *   @SWG\Response(
     *     response="500",
     *     description="Internal Server Error"
     *   )
     * )
     */
    public function doGet(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // load the requested path info, e. g. /api/applications.do/example/
        $pathInfo = trim($servletRequest->getPathInfo(), '/');

        // extract the entity and the ID, if available
        list ($id, ) = explode('/', $pathInfo);

        // query whether we've found an ID or not
        if ($id == null) {
            $content = $this->applicationProcessor->findAll();
        } else {
            $content = $this->applicationProcessor->load($id);
        }

        // return the JSON encoded response
        $servletResponse->appendBodyStream(json_encode($content));
    }

    /**
     * Creates a new app.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doPost()
     *
     * @SWG\Post(
     *   path="/applications.do",
     *   tags={"applications"},
     *   summary="creates a new application",
     *   consumes={"multipart/form-data"},
     *   @SWG\Parameter(
     *      name="file",
     *      in="formData",
     *      description="The PHAR archive containing the application",
     *      required=true,
     *      type="file"
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="a ""success"" message"
     *   ),
     *   @SWG\Response(
     *     response="500",
     *     description="Internal Server Error"
     *   )
     * )
     */
    public function doPost(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // load the HTTP part
        $part = $servletRequest->getPart(ApplicationServlet::UPLOADED_PHAR_FILE);

        // upload the file
        $this->applicationProcessor->upload($part->getFilename(), $part->getInputStream());
    }

    /**
     * Delete the requested application.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doDelete()
     *
     * @SWG\Delete(
     *   path="/applications.do/{id}",
     *   tags={"applications"},
     *   summary="deletes an existing application",
     *   @SWG\Parameter(
     *      name="id",
     *      in="path",
     *      description="The name of the application to delete",
     *      required=true,
     *      type="string"
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="a ""success"" message"
     *   ),
     *   @SWG\Response(
     *     response="500",
     *     description="Internal Server Error"
     *   )
     * )
     */
    public function doDelete(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // load the requested path info, e. g. /api/applications.do/example/
        $pathInfo = trim($servletRequest->getPathInfo(), '/');

        // extract the entity and the ID, if available
        list ($id, ) = explode('/', $pathInfo);

        // undeploy the application
        $this->applicationProcessor->delete($id);
    }
}
