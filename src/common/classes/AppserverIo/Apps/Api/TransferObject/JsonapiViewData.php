<?php

/**
 * AppserverIo\Apps\Api\TransferObject\JsonapiOverviewData
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
use Rhumsaa\Uuid\Uuid;

/**
 * DTO for the JSON-API version.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @SWG\Definition(type="object", required={"version"})
 */
class JsonapiViewData
{

    /**
     * The JSON-API version number.
     *
     * @var string
     * @SWG\Property(property="version", type="string")
     */
    protected $version = '1.0';

    /**
     * Set's the JSON-API version number.
     *
     * @param string $version The version number
     *
     * @return void
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * Return's the JSON-API version number
     *
     * @return string The version number
     */
    public function getVersion()
    {
        return $this->version;
    }
}
