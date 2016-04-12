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

use Rhumsaa\Uuid\Uuid;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Builder;
use AppserverIo\Psr\HttpMessage\Protocol;
use AppserverIo\Psr\Security\PrincipalInterface;
use AppserverIo\Server\Dictionaries\ServerVars;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;
use AppserverIo\Appserver\ServletEngine\Authenticator\Utils\FormKeys;
use AppserverIo\Appserver\ServletEngine\Authenticator\FormAuthenticator;
use AppserverIo\Collections\ArrayList;
use AppserverIo\Lang\String;
use  AppserverIo\Appserver\ServletEngine\Security\GenericPrincipal;

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
     * Try to authenticate the user making this request, based on the specified login configuration.
     *
     * Return TRUE if any specified constraint has been satisfied, or FALSE if we have created a response
     * challenge already.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The servlet request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The servlet response instance
     *
     * @return boolean TRUE if authentication has already been processed on a request before, else FALSE
     * @throws \AppserverIo\Http\Authentication\AuthenticationException Is thrown if the request can't be authenticated
     */
    public function authenticate(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // extract the JWT from the header
        list ($jwt) = sscanf($servletRequest->getHeader(Protocol::HEADER_AUTHORIZATION), 'Bearer %s');

        // query whether or not a token can be found
        if ($jwt) {
            // parse the token and register the found principal in the request
            $token = (new Parser())->parse((string) $jwt);

            $principal = $token->getClaim('principal');

            $username = new String($principal->username);

            $roles = new ArrayList();
            foreach ($principal->roles as $role) {
                $roles->add(new String($role));
            }

            $userPrincipal = new GenericPrincipal($username, null, $roles);

            $this->register($servletRequest, $servletResponse, $userPrincipal);
            return true;
        }

        // is this the action request from the login page?
        if (FormKeys::FORM_ACTION !== pathinfo($servletRequest->getRequestUri(), PATHINFO_FILENAME)) {
            // invoke the onLogin callback and redirect to the login page
            $this->onLogin($servletRequest, $servletResponse);
            return false;
        }

        // invoke the onCredentials callback to load the credentials from the request
        $this->onCredentials($servletRequest, $servletResponse);

        // load the realm to authenticate this request for
        /** @var AppserverIo\Appserver\ServletEngine\Security\RealmInterface $realm */
        $realm = $this->getAuthenticationManager()->getRealm($this->getRealmName());

        // authenticate the request and initialize the user principal
        $userPrincipal = $realm->authenticate($this->getUsername(), $this->getPassword());

        // query whether or not the realm returned an authenticated user principal
        if ($userPrincipal == null) {
            // invoke the onFailure callback and forward the user to the error page
            $this->onFailure($realm, $servletRequest, $servletResponse);
            return false;
        }

        // invoke the onSuccess callback and redirect the user to the original page
        $this->onSuccess($userPrincipal, $servletRequest, $servletResponse);
        return false;
    }

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

        $roles = array();
        foreach ($userPrincipal->getRoles() as $role) {
            $roles[] = $role->__toString();
        }

        $principal = array(
            'username' => $userPrincipal->getUsername()->__toString(),
            'roles'    => $roles
        );

        // configure the JWT token
        $token = (new Builder())->setIssuer($servletRequest->getServerName())                         // configures the issuer (iss claim)
                                ->setAudience($servletRequest->getServerVar(ServerVars::REMOTE_HOST)) // configures the audience (aud claim)
                                ->setId(Uuid::uuid4(), true)                                          // configures the id (jti claim), replicating as a header item
                                ->setIssuedAt(time())                                                 // configures the time that the token was issue (iat claim)
                                ->setNotBefore(time() + 60)                                           // configures the time that the token can be used (nbf claim)
                                ->setExpiration(time() + 3600)                                        // configures the expiration time of the token (exp claim)
                                ->set('principal', $principal)                                        // configures a new claim, called "principal"
                                ->getToken();                                                         // retrieves the generated token

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

        // add the user principal and the authentication type to the request
        $this->register($servletRequest, $servletResponse, $userPrincipal);
    }
}
