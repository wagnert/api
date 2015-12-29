<?php

/**
 * AppserverIo\Apps\Api\Servlets\AuthenticationAwareServlet
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

use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;

/**
 * Trait that provides authentication functionality.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
trait AuthenticationTrait
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
     * Queries whether or not a valid user has been logged into the system.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return boolean TRUE if a user has been logged into the system, else FALSE
     */
    public function isAuthenticated(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // try to start the session
        /** @var \AppserverIo\Psr\Servlet\Http\HttpSessionInterface $session */
        $session = $servletRequest->getSession(true);
        $session->start();

        // query whether or no an user has already been authenticated
        return $this->getAuthenticationProvider()->isAuthenticated();
    }
}
