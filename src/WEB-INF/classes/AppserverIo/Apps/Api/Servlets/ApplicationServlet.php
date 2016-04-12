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
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Apps\Api\Servlets;

use AppserverIo\Apps\Api\Utils\RequestKeys;
use AppserverIo\Apps\Api\Encoding\EncodingAwareInterface;
use AppserverIo\Apps\Api\Validation\ValidationAwareInterface;
use AppserverIo\Apps\Api\TransferObject\ErrorOverviewData;
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
 * @Route(name="applications",
 *        displayName="Handles application related requests",
 *        description="A servlet implementation that handles all application related requests.",
 *        urlPattern={"/applications.do", "/applications.do*"})
 */
class ApplicationServlet extends AbstractServlet implements ValidationAwareInterface, EncodingAwareInterface
{

    /**
     * Filename of the uploaded file with the webapp PHAR.
     *
     * @var string
     */
    const UPLOADED_PHAR_FILE = 'file';

    /**
     * The application processor instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Services\ApplicationProcessorInterface
     * @EnterpriseBean
     */
    protected $applicationProcessor;

    /**
     * Return's the application processor instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The processor proxy
     * @see \AppserverIo\Apps\Api\Services\ApplicationProcessorInterface
     */
    public function getApplicationProcessor()
    {
        return $this->applicationProcessor;
    }

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
     *     response=500,
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
     *     response=500,
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
            $content = $this->getApplicationProcessor()->findAll();
        } else {
            $content = $this->getApplicationProcessor()->load($id);
        }

        // add the result to the request
        $servletRequest->setAttribute(RequestKeys::RESULT, $content);
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
     *   summary="Create's a new application",
     *   consumes={"multipart/form-data"},
     *   @SWG\Parameter(
     *      name="containerId",
     *      in="formData",
     *      description="The ID of the container to deploy the PHAR archive to",
     *      required=true,
     *      type="string"
     *   ),
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
     *     response=500,
     *     description="Internal Server Error"
     *   )
     * )
     */
    public function doPost(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // query whether we've found an container ID and the PHAR archive
        if ($servletRequest->hasParameter(RequestKeys::CONTAINER_ID) &&
            $pharArchive = $servletRequest->getPart(ApplicationServlet::UPLOADED_PHAR_FILE)
        ) {
            // save file to appserver's upload tmp folder with a temporary name
            $pharArchive->init();
            $pharArchive->write($pharArchive->getFilename());

            // upload the file
            $this->getApplicationProcessor()->upload(
                $servletRequest->getParameter(RequestKeys::CONTAINER_ID),
                $pharArchive->getFilename()
            );

        } else {
            $this->addError(ErrorOverviewData::factoryForPointer(500, 'Missing container ID or corrupt PHAR archive'));
        }
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
     *   summary="Delete's an existing application",
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
     *     response=500,
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
        $this->getApplicationProcessor()->delete($id);
    }

    /**
     * Delete the requested application.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doOptions()
     */
    public function doOptions(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {
    }
}
