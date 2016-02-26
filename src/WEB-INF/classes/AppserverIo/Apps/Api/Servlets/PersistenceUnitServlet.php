<?php

/**
 * AppserverIo\Apps\Api\Servlets\PersistenceUnitServlet
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
 * Servlet that handles all persistence unit related requests.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Route(name="persistenceUnits",
 *        displayName="Handles persistence unit related requests",
 *        description="A servlet implementation that handles all persistence unit related requests.",
 *        urlPattern={"/persistenceUnits.do", "/persistenceUnits.do*"})
 */
class PersistenceUnitServlet extends AbstractServlet implements EncodingAwareInterface
{

    /**
     * The persistence unit processor instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Services\PersistenceUnitProcessorInterface
     * @EnterpriseBean
     */
    protected $persistenceUnitProcessor;

    /**
     * Return's the persistence unit processor instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The processor proxy
     * @see \AppserverIo\Apps\Api\Services\PersistenceUnitProcessorInterface
     */
    public function getPersistenceUnitProcessor()
    {
        return $this->persistenceUnitProcessor;
    }

    /**
     * Tries to load the available persistence units and adds them to the response.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doGet()
     *
     * @SWG\Get(
     *   path="/persistenceUnits.do",
     *   tags={"persistenceUnits"},
     *   summary="List's all persistence units",
     *   @SWG\Response(
     *     response=200,
     *     description="A list with the available persistence units",
     *     @SWG\Schema(
     *       type="array",
     *       @SWG\Items(ref="#/definitions/PersistenceUnitOverviewData")
     *     )
     *   ),
     *   @SWG\Response(
     *     response=500,
     *     description="Internal Server Error"
     *   )
     * )
     *
     * @SWG\Get(
     *   path="/persistenceUnits.do/{id}",
     *   tags={"persistenceUnits"},
     *   summary="Load's the persistence unit with the passed ID",
     *   @SWG\Parameter(
     *      name="id",
     *      in="path",
     *      description="The name of the persistence unit to load",
     *      required=true,
     *      type="string"
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="The requested persistence unit",
     *     @SWG\Schema(
     *       ref="#/definitions/PersistenceUnitViewData"
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

        // load the requested path info, e. g. /api/persistenceUnits.do
        $pathInfo = trim($servletRequest->getPathInfo(), '/');

        // extract the entity and the ID, if available
        list ($id, ) = explode('/', $pathInfo);

        // query whether we've found an ID or not
        if ($id == null) {
            $content = $this->getPersistenceUnitProcessor()->findAll();
        } else {
            $content = $this->getPersistenceUnitProcessor()->load($id);
        }

        // add the result to the request
        $servletRequest->setAttribute(RequestKeys::RESULT, $content);
    }
}
