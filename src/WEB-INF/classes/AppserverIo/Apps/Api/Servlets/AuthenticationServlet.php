<?php

/**
 * AppserverIo\Apps\Api\Servlets\AuthenticationServlet
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

use AppserverIo\Lang\String;
use AppserverIo\Apps\Api\Utils\RequestKeys;
use AppserverIo\Apps\Api\Encoding\EncodingAwareInterface;
use AppserverIo\Apps\Api\Validation\ValidationAwareInterface;
use AppserverIo\Apps\Api\TransferObject\ErrorOverviewData;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;

/**
 * Servlet to handle a simple welcome page request.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Route(name="authentication",
 *        displayName="Handles login/logout requests",
 *        description="A servlet implementation that handles login/logout related requests.",
 *        urlPattern={"/authentication.do", "/authentication.do*"})
 */
class AuthenticationServlet extends AbstractServlet implements ValidationAwareInterface, EncodingAwareInterface
{

    /**
     * The service providing the authentication functionality.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Encoder\EncoderInterface
     * @EnterpriseBean(beanName="UserProcessor")
     */
    protected $authenticationProvider;

    /**
     * Returns the encoder instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Encoder\EncoderInterface
     */
    public function getAuthenticationProvider()
    {
        return $this->authenticationProvider;
    }

    /**
     * Destroy's the actual session and log's the authenticated user out of the API.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doGet()
     *
     * @SWG\Get(
     *   path="/authentication.do",
     *   tags={"authentication"},
     *   summary="Logout",
     *   @SWG\Response(
     *     response=200,
     *     description="Successfull Logout"
     *   ),
     *   @SWG\Response(
     *     response=500,
     *     description="Internal Server Error"
     *   )
     * )
     */
    public function doGet(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {
        $this->addError(ErrorOverviewData::factoryForPointer(401, 'Authentication Required'));
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
     *   path="/authentication.do",
     *   tags={"authentication"},
     *   summary="Login",
     *   @SWG\Response(
     *     response=200,
     *     description="Successfull Login"
     *   ),
     *   @SWG\Response(
     *     response=500,
     *     description="Internal Server Error"
     *   )
     * )
     */
    public function doPost(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // login the user principal and load the DTO representation
        $viewData = $this->getAuthenticationProvider()->login($servletRequest->getUserPrincipal());

        // set the DTO representation to the response
        $servletRequest->setAttribute(RequestKeys::RESULT, $viewData);
    }
}
