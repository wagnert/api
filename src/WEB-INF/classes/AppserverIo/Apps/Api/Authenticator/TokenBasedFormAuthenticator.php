<?php

/**
 * AppserverIo\Apps\Api\Authenticator\TokenBasedFormAuthenticator
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

namespace AppserverIo\Apps\Api\Authenticator;

use Lcobucci\JWT\Builder;
use AppserverIo\Psr\Security\PrincipalInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;
use AppserverIo\Appserver\ServletEngine\Authenticator\FormAuthenticator;

/**
 * Custom RESTFul API optimized form authenticator.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
class TokenBasedFormAuthenticator extends FormAuthenticator
{

    /**
     * Will be invoked on a successfull login.
     *
     * @param \AppserverIo\Psr\Security\PrincipalInterface               $userPrincipal   The user principal logged into the system
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The servlet request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The servlet response instance
     *
     * @return void
     */
    protected function onSuccess(
        PrincipalInterface $userPrincipal,
        HttpServletRequestInterface $servletRequest,
        HttpServletResponseInterface $servletResponse
    ) {

        // add the user principal and the authentication type to the request
        $this->register($servletRequest, $servletResponse, $userPrincipal);

        // configure the JWT token
        $token = (new Builder())->setIssuer('http://example.com')   // configures the issuer (iss claim)
                                ->setAudience('http://example.org') // configures the audience (aud claim)
                                ->setId('4f1g23a12aa', true)        // cnfigures the id (jti claim), replicating as a header item
                                ->setIssuedAt(time())               // configures the time that the token was issue (iat claim)
                                ->setNotBefore(time() + 60)         // configures the time that the token can be used (nbf claim)
                                ->setExpiration(time() + 3600)      // configures the expiration time of the token (exp claim)
                                ->set('uid', 1)                     // configures a new claim, called "uid"
                                ->getToken();                       // retrieves the generated token

        // append the JWT token to the response body
        $servletResponse->appendBodyStream(
            json_encode(
                array(
                    'accessToken' => $token->__toString(),
                    'tokenType'   => 'jwt',
                    'expiresIn'   => 3600
                )
            )
        );

        // set the request dispatched
        $servletRequest->setDispatched(true);
    }
}
