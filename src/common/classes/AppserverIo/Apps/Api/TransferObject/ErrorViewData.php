<?php

/**
 * AppserverIo\Apps\Api\TransferObject\ErrorViewData
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

namespace AppserverIo\Apps\Api\TransferObject;

use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMS;

/**
 * DTO for the error view data implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @SWG\Definition(type="object", required={"jsonapi", "errors"})
 */
class ErrorViewData
{

    /**
     * The JSON-API version number.
     *
     * @var string
     * @SWG\Property(property="jsonapi", type="\AppserverIo\Apps\Api\TransferObject\JsonapiViewData")
     */
    protected $jsonapi;

    /**
     * The array with the errors.
     *
     * @var array
     * @SWG\Property(property="errors", type="array", @SWG\Items(type="\AppserverIo\Apps\Api\TransferObject\JsonapiViewData"))
     */
    protected $errors;

    /**
     * Initializes the DTO with the passed data.
     *
     * @param array                                                     $errors  The array with the errors
     * @param \AppserverIo\Apps\Api\TransferObject\JsonapiViewData|null $jsonapi The version number
     */
    public function __construct(array $errors = array(), JsonapiViewData $jsonapi = null)
    {

        // set the passed errors
        $this->errors = $errors;

        // query whether we've a version number passed or not
        if ($jsonapi) {
            $this->jsonapi = $jsonapi;
        } else {
            $this->jsonapi = new JsonapiViewData();
        }
    }

    /**
     * Set's the JSON-API version number.
     *
     * @param \AppserverIo\Apps\Api\TransferObject\JsonapiViewData $jsonapi The version number
     *
     * @return void
     */
    public function setJsonapi(JsonapiViewData $jsonapi)
    {
        $this->jsonapi = $jsonapi;
    }

    /**
     * Return's the JSON-API version number.
     *
     * @return \AppserverIo\Apps\Api\TransferObject\JsonapiViewData The JSON-API version number
     */
    public function getJsonapi()
    {
        return $this->jsonapi;
    }

    /**
     * Set's the errors.
     *
     * @param array $code The errors
     *
     * @return void
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * Return's the errors.
     *
     * @return array The errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Return's the size of the errors.
     *
     * @return integer The error size
     */
    public function size()
    {
        return sizeof($this->errors);
    }
}
