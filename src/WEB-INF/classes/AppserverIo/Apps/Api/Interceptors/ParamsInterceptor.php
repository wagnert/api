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

use AppserverIo\Psr\Servlet\ServletInterface;
use AppserverIo\Psr\MetaobjectProtocol\Aop\MethodInvocationInterface;

/**
 * Interceptor that set's all request parameters to the action by using setter methods.
 *
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2015 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://github.com/appserver-io/routlt
 * @link       http://www.appserver.io
 */
class ParamsInterceptor
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
        return $this->getParameter(ParamsInterceptor::SERVLET_REQUEST);
    }

    /**
     * Returns the instance of the actual servlet response.
     *
     * @return \AppserverIo\Psr\Servlet\ServletResponseInterface The actual servlet response instance
     */
    public function getServletResponse()
    {
        return $this->getParameter(ParamsInterceptor::SERVLET_RESPONSE);
    }

    /**
     * Iterates over all servlet request parameters and tries to find and
     * invoke a setter with the param that matches the setters name.
     *
     * @param AppserverIo\Psr\MetaobjectProtocol\Aop\MethodInvocationInterface $methodInvocation Initially invoked method
     *
     * @return string|null The action result
     */
    public function intercept(MethodInvocationInterface $methodInvocation)
    {

        // load the method invocation parameters
        $this->setParameters($methodInvocation->getParameters());

        // load the servlet instance
        $servlet = $methodInvocation->getContext();

        // get the servlet's methods
        $methods = get_class_methods($servlet);

        // try to inject the request parameters by using the class setters
        foreach ($this->getServletRequest()->getParameterMap() as $key => $value) {
            // prepare the setter method name
            $methodName = sprintf('set%s', ucfirst($key));

            // query whether the class has the setter implemented
            if (in_array($methodName, $methods) === false) {
                continue;
            }

            try {
                // set the value by using the setter
                $servlet->$methodName($value);

            } catch (\Exception $e) {
                $servlet->addError(array($key => $e->getMessage()));
            }
        }
    }
}
