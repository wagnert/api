<?php

/**
 * AppserverIo\Apps\Api\TransferObject\NamingDirectoryViewData
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
 * DTO for the naming directory view data implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @SWG\Definition(type="object", required={"id", "values"})
 */
class NamingDirectoryViewData extends NamingDirectoryOverviewData
{

    /**
     * The naming directory values.
     *
     * @var array
     * @SWG\Property(property="values", type="array", @SWG\Items(type="string"))
     */
    protected $values = array();

    /**
     * Set's the naming directory values.
     *
     * @param array $values The naming directory values
     *
     * @return void
     */
    public function setValues(array $values)
    {
        $this->values = $values;
    }

    /**
     * Return's the naming directory values.
     *
     * @return array The naming directory values
     */
    public function getValues()
    {
        return $this->values;
    }
}
