<?php

/**
 * AppserverIo\Apps\Api\TransferObject\SourceViewData
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

/**
 * DTO for the error source data.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @SWG\Definition(type="object")
 */
class SourceViewData
{

    /**
     * The pointer to where the problem occurs in the request document.
     *
     * @var string
     * @SWG\Property(property="pointer", type="string")
     */
    public $pointer;

    /**
     * The name of a missing or invalid parameter.
     *
     * @var string
     * @SWG\Property(property="parameter", type="string")
     */
    public $parameter;

    /**
     * Initializes the DTO with the passed data.
     *
     * @param string|null $pointer   The pointer to where the problem occurs in the request document
     * @param string|null $parameter The name of a missing or invalid parameter
     */
    public function __construct($pointer = null, $parameter = null)
    {
        $this->pointer = $pointer;
        $this->parameter = $parameter;
    }

    /**
     * Set's the pointer to where the problem occurs in the request document.
     *
     * @param string $pointer The referencing pointer
     *
     * @return void
     */
    public function setPointer($pointer)
    {
        $this->pointer = $pointer;
    }

    /**
     * Return's the pointer to where the problem occurs in the request document
     *
     * @return string|null The referencing pointer
     */
    public function getPointer()
    {
        return $this->pointer;
    }

    /**
     * Set's the name of a missing or invalid parameter.
     *
     * @param string $parameter The parameter name
     *
     * @return void
     */
    public function setParameter($parameter)
    {
        $this->parameter = $parameter;
    }

    /**
     * Return's the name of a missing or invalid parameter
     *
     * @return string|null The parameter name
     */
    public function getParameter()
    {
        return $this->parameter;
    }
}
