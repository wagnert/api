<?php

/**
 * AppserverIo\Apps\Api\Assembler\JsonApi\ErrorAssembler
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

namespace AppserverIo\Apps\Api\Assembler\JsonApi;

use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Collection;
use AppserverIo\Apps\Api\TransferObject\ErrorViewData;
use AppserverIo\Apps\Api\Assembler\ErrorAssemblerInterface;
use AppserverIo\Apps\Api\Assembler\JsonApi\Serializer\ErrorSerializer;

/**
 * A SLSB implementation providing the business logic to assemble virtual hosts
 * to a JSON-API compatible format.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class ErrorAssembler implements ErrorAssemblerInterface
{

    /**
     * Convert's the passed error DTOs into a new DTO representation.
     *
     * @param array $errors The error DTOs to convert
     *
     * @return AppserverIo\Apps\Api\TransferObject\ErrorViewData The DTO with the error data
     */
    public function toErrorViewData(array $errors)
    {
        return new ErrorViewData($errors);
    }
}
