<?php

/**
 * AppserverIo\Apps\Api\Servlets\IndexServlet
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

use AppserverIo\Apps\Api\Utils\RequestKeys;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;

/**
 * Servlet to handle a simple welcome page request.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 *
 * @SWG\Info(
 *   title="Internal appserver.io API",
 *   version="0.1",
 *   contact={"name":"Tim Wagner", "url":"http://www.appserver.io", "email":"tw@appserver.io"},
 *   license={"name":"OSL 3.0", "url"="http://opensource.org/licenses/osl-3.0.php"}
 * )
 *
 * @SWG\Swagger(
 *   schemes={"http", "https"},
 *   host="127.0.0.1:9024",
 *   basePath="/api",
 *   produces={"application/json"},
 *   swagger="2.0"
 * )
 */
class IndexServlet extends EncodingAwareServlet
{

    /**
     * The user processor instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @var \AppserverIo\Apps\Api\Services\UserProcessorInterface
     * @EnterpriseBean
     */
    protected $userProcessor;

    /**
     * The system logger implementation.
     *
     * @var \AppserverIo\Logger\Logger
     * @Resource(lookup="php:global/log/System")
     */
    protected $systemLogger;

    /**
     * Return's the user processor instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The processor proxy
     * @see \AppserverIo\Apps\Api\Services\UserProcessorInterface
     */
    public function getUserProcessor()
    {
        return $this->userProcessor;
    }

    /**
     * Return's the system logger instance.
     *
     * @return \AppserverIo\Logger\Logger The logger instance
     */
    protected function getSystemLogger()
    {
        return $this->systemLogger;
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
     *   path="/index.do",
     *   summary="Welcome Page",
     *   tags={"index"},
     *   @SWG\Response(
     *     response=200,
     *     description="A simple welcome page"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function doGet(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {
        $servletRequest->setAttribute(RequestKeys::RESULT, array('Welcome to appserver.io API'));
    }

    /**
     * Log the user into the API.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doPost()
     *
     * @SWG\Post(
     *   path="/index.do",
     *   summary="Login",
     *   tags={"index"},
     *   @SWG\Response(
     *     response=200,
     *     description="A simple welcome page"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function doPost(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        try {
            // start the session, if not already done
            /** @var \AppserverIo\Psr\Servlet\Http\HttpSessionInterface $session */
            $session = $servletRequest->getSession(true);
            $session->start();

            // load username + password from the request
            $username = $servletRequest->getParameter(RequestKeys::USERNAME);
            $password = $servletRequest->getParameter(RequestKeys::PASSWORD);

            // try to login the user into the system
            if ($username && $password) {
                $content = $this->getUserProcessor()->login($username, $password);
            }

        } catch (\Exception $e) {
            // log the exception
            $this->getSystemLogger()->error($e->__toString());
            // set the exception message as response body
            $content = $e->getMessage();
        }

        // add the result to the request
        $servletRequest->setAttribute(RequestKeys::RESULT, $content);
    }
}
