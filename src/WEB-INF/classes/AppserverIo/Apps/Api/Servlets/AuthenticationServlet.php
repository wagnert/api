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

use Respect\Validation\Validator as v;
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
class AuthenticationServlet extends AbstractServlet implements EncodingAwareInterface, ValidationAwareInterface
{

    /**
     * The username for login purposes.
     *
     * @var string
     */
    protected $username;

    /**
     * The password for login purposes.
     *
     * @var string
     */
    protected $password;

    /**
     * The service providing the authentication functionality.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Encoder\EncoderInterface
     * @EnterpriseBean(beanName="UserProcessor")
     */
    protected $authenticationProvider;

    /**
     * Set's the username found as request parameter.
     *
     * @param string|null $username The username
     *
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Return's the password found as request parameter.
     *
     * @return string|null The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set's the password found as request parameter.
     *
     * @param string|null $password The password
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Return's the password found as request paramater.
     *
     * @return string|null The password
     */
    public function getPassword()
    {
        return $this->password;
    }

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
     * Validates the user credentials on a Post request.
     *
     * @return void
     * @ValidateOnPost
     */
    public function validateOnPost()
    {

        // validate the username
        if (v::stringType()->length(4, 16)->validate($this->getUsername()) === false) {
            $this->addError(ErrorOverviewData::factoryForParameter(500, 'Username must have between 4 and 16 chars', 'username'));
        }

        // validate the password
        if (v::stringType()->length(8, 16)->validate($this->getPassword()) === false) {
            $this->addError(ErrorOverviewData::factoryForParameter(500, 'Password must have between 8 and 16 chars', 'password'));
        }
    }

    /**
     * Logs the user with the data found in the request into the system.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     */
    public function authenticate(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        try {
            // start the session, if not already done
            /** @var \AppserverIo\Psr\Servlet\Http\HttpSessionInterface $session */
            $session = $servletRequest->getSession(true);
            $session->start();

            // try to login the user into the system add the result to the request
            $servletRequest->setAttribute(RequestKeys::RESULT, $this->getAuthenticationProvider()->login($this->getUsername(), $this->getPassword()));

        } catch (\Exception $e) {
            // log the exception
            $this->getSystemLogger()->error($e->__toString());
            // set the exception message as response body
            $this->addError(ErrorOverviewData::factoryForParameter(500, $e->getMessage()));
        }
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
        // start the session, if not already done and destroy the session and reset the cookie
        /** @var \AppserverIo\Psr\Servlet\Http\HttpSessionInterface $session */
        $session = $servletRequest->getSession(true);
        $session->destroy('Explicit logout requested by: ' . $this->getAuthenticationProvider()->getAuthenticatedUser()->getUsername());
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
     *   @SWG\Parameter(
     *      name="username",
     *      in="formData",
     *      description="The username used to login to the API",
     *      required=true,
     *      type="string"
     *   ),
     *   @SWG\Parameter(
     *      name="password",
     *      in="formData",
     *      description="The password used to login to the API",
     *      required=true,
     *      type="string"
     *   ),
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
        $this->authenticate($servletRequest, $servletResponse);
    }
}
