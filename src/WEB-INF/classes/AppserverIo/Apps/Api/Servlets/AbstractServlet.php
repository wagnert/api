<?php

/**
 * AppserverIo\Apps\Api\Servlets\AbstractServlet
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
use AppserverIo\Psr\Servlet\Http\HttpServlet;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;
use AppserverIo\Appserver\Core\InitialContext;
use AppserverIo\Api\Service\Service;

/**
 * Abstract servlet that provides basic functionality for
 * all other API servlets.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
abstract class AbstractServlet extends HttpServlet
{

    /**
     * Returns the servlets service class to use.
     *
     * @return string The servlets service class
     */
    abstract public function getServiceClass();

    /**
     * Returns the actual service instance to use.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface $servletRequest The request instance
     *
     * @return \AppserverIo\Apps\Api\Service\Service The requested service instance
     */
    public function getService(HttpServletRequestInterface $servletRequest)
    {
        $service = $servletRequest->getContext()->newService($this->getServiceClass());
        $service->setWebappPath($servletRequest->getContext()->getWebappPath());
        return $service;
    }

    /**
     * Generic finder implementation using the actual service instance.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Apps\Api\Service\Service::load();
     * @see \AppserverIo\Apps\Api\Service\Service::findAll();
     */
    public function find(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // load the requested URI
        $uri = trim($servletRequest->getUri(), '/');

        // first check if a collection of ID's has been requested
        if ($ids = $servletRequest->getParameter('ids')) {
            // load all entities with the passed ID's
            $content = array();
            foreach ($ids as $id) {
                $content[] = $this->getService($servletRequest)->load($id);
            }

        // then check if all entities has to be loaded or exactly one
        } else {
            // extract the ID of available, and load the requested OR all entities
            list ($applicationName, $entity, $id) = explode('/', $uri, 3);
            if ($id == null) {
                $content = $this->getService($servletRequest)->findAll();
            } else {
                $content = $this->getService($servletRequest)->load($id);
            }
        }

        // set the JSON encoded data in the response
        $servletResponse->addHeader(HttpProtocol::HEADER_CONTENT_TYPE, 'application/json');

        $servletResponse->addHeader('Access-Control-Allow-Origin', '*');
        $servletResponse->addHeader('Access-Control-Allow-Methods', 'GET, POST, DELETE, PUT, PATCH, OPTIONS');
        $servletResponse->addHeader('Access-Control-Allow-Headers', 'Content-Type, api_key, Authorization');

        $servletResponse->appendBodyStream(json_encode($content));
    }

    /**
     * Returns the application's base URL for html base tag
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface $servletRequest The request instance
     *
     * @return string The applications base URL
     */
    public function getBaseUrl(HttpServletRequestInterface $servletRequest)
    {
        // initialize the base URL
        $baseUrl = '/';

        // if the application has NOT been called over a VHost configuration append application folder name
        if (!$servletRequest->getContext()->isVhostOf($servletRequest->getServerName())) {
            $baseUrl .= $servletRequest->getContext()->getName() . '/';
        }

        // return the base URL
        return $baseUrl;
    }
}
