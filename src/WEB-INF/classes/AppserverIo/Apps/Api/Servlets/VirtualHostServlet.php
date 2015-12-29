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
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Apps\Api\Servlets;

use AppserverIo\Apps\Api\Utils\RequestKeys;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;
use AppserverIo\Apps\Api\Encoding\EncodingAwareInterface;
use AppserverIo\Apps\Api\Authentication\AuthenticationAwareInterface;

/**
 * Servlet that handles all virtual host related requests.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Route(name="virtualHosts",
 *        displayName="Handles virtual host related requests",
 *        description="A servlet implementation that handles all virtual host related requests.",
 *        urlPattern={"/virtualHosts.do", "/virtualHosts.do*"})
 */
class VirtualHostServlet extends AbstractServlet implements EncodingAwareInterface, AuthenticationAwareInterface
{

    /**
     * The virtual host processor instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Services\VirtualHostProcessorInterface
     * @EnterpriseBean
     */
    protected $virtualHostProcessor;

    /**
     * Return's the virtual host processor instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The processor proxy
     * @see \AppserverIo\Apps\Api\Services\VirtualHostProcessorInterface
     */
    public function getVirtualHostProcessor()
    {
        return $this->virtualHostProcessor;
    }

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
     *   path="/virtualHosts.do",
     *   tags={"virtualHosts"},
     *   summary="List's all virtual hosts",
     *   @SWG\Response(
     *     response=200,
     *     description="A list with the available virtual hosts",
     *     @SWG\Schema(
     *       type="array",
     *       @SWG\Items(ref="#/definitions/VirtualHostOverviewData")
     *     )
     *   ),
     *   @SWG\Response(
     *     response="500",
     *     description="Internal Server Error"
     *   )
     * )
     *
     * @SWG\Get(
     *   path="/virtualHosts.do/{id}",
     *   tags={"virtualHosts"},
     *   summary="Loads the virtual host with the passed ID",
     *   @SWG\Parameter(
     *      name="id",
     *      in="path",
     *      description="The UUID of the virtual host to load",
     *      required=true,
     *      type="string"
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="The requested virtual host",
     *     @SWG\Schema(
     *       ref="#/definitions/VirtualHostViewData"
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

        try {
            // load the requested path info, e. g. /api/applications.do/example/
            $pathInfo = trim($servletRequest->getPathInfo(), '/');

            // extract the entity and the ID, if available
            list ($id, ) = explode('/', $pathInfo);

            // query whether we've found an ID or not
            if ($id == null) {
                $content = $this->getVirtualHostProcessor()->findAll();
            } else {
                $content = $this->getVirtualHostProcessor()->load($id);
            }

        } catch (\Exception $e) {
            // set error message and status code
            $content = $e->getMessage();
            $servletResponse->setStatusCode(500);
        }

        // add the result to the request
        $servletRequest->setAttribute(RequestKeys::RESULT, $content);
    }
}
