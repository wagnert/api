<?php

/**
 * AppserverIo\Apps\Api\Errors\ErrorHandler
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

namespace AppserverIo\Apps\Api\Errors;

use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;

/**
 * A simple error handler implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @EPB\Stateless
 */
class ErrorHandler implements ErrorHandlerInterface
{

    /**
     * The assembler to convert the errors.
     *
     * @EPB\EnterpriseBean
     */
    protected $errorAssembler;

    /**
     * Transforms the passed errors into a compatible structure.
     *
     * @param array $errors The array containing the errors
     *
     * @return mixed The transformed errors
     */
    public function processErrors(array $errors)
    {
        return $this->errorAssembler->toErrorViewData($errors);
    }
}
