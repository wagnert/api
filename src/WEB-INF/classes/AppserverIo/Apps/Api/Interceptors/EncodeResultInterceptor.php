<?php

/**
 * AppserverIo\Apps\Api\Interceptors\EncodeResultInterceptor
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Bernhard Wick <bw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Apps\Api\Interceptors;

use AppserverIo\Apps\Api\Encoding\EncodingAwareInterface;
use AppserverIo\Apps\Api\Validation\ValidationAwareInterface;
use AppserverIo\Psr\MetaobjectProtocol\Aop\MethodInvocationInterface;
use AppserverIo\Psr\MetaobjectProtocol\Aop\Annotations as AOP;

/**
 * Interceptor to encode the response data.
 *
 * @author    Bernhard Wick <bw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @AOP\Aspect
 */
class EncodeResultInterceptor
{

    /**
     * The key of the servlet request in the method invocation parameters.
     *
     * @var string
     */
    const SERVLET_REQUEST = 'servletRequest';

    /**
     * The key of the servlet response in the method invocation parameters.
     *
     * @var string
     */
    const SERVLET_RESPONSE = 'servletResponse';

    /**
     * The parameters of the actual method invocation.
     *
     * @var \AppserverIo\Psr\Servlet\ServletRequestInterface
     */
    protected $parameters = array();

    /**
     * Sets the method invocation parameters.
     *
     * @param array $parameters The method invocation parameters
     *
     * @return void
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns the requsted method invocation parameter.
     *
     * @param string $name Name of the parameter to return
     *
     * @return mixed The requested parameter if available
     */
    public function getParameter($name)
    {
        if (isset($this->parameters[$name])) {
            return $this->parameters[$name];
        }
    }

    /**
     * Returns the instance of the actual servlet request.
     *
     * @return \AppserverIo\Psr\Servlet\ServletRequestInterface The actual servlet request instance
     */
    public function getServletRequest()
    {
        return $this->getParameter(EncodeResultInterceptor::SERVLET_REQUEST);
    }

    /**
     * Returns the instance of the actual servlet response.
     *
     * @return \AppserverIo\Psr\Servlet\ServletResponseInterface The actual servlet response instance
     */
    public function getServletResponse()
    {
        return $this->getParameter(EncodeResultInterceptor::SERVLET_RESPONSE);
    }

    /**
     * Advice used to encode the response data.
     *
     * @param \AppserverIo\Psr\MetaobjectProtocol\Aop\MethodInvocationInterface $methodInvocation Initially invoked method
     *
     * @return void
     */
    public function intercept(MethodInvocationInterface $methodInvocation)
    {

        // load the method invocation parameters
        $this->setParameters($methodInvocation->getParameters());

        // load the servlet instance
        $servlet = $methodInvocation->getContext();

        // query whether or not we've to process errors
        if ($servlet instanceof ValidationAwareInterface && $servlet->hasErrors()) {
            $servlet->processErrors($this->getServletRequest(), $this->getServletResponse());
        }

        // query whether or not we've to encode the request
        if ($servlet instanceof EncodingAwareInterface) {
            $servlet->encode($this->getServletRequest(), $this->getServletResponse());
        }
    }
}
