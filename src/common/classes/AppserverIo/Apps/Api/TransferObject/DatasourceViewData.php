<?php

/**
 * AppserverIo\Apps\Api\TransferObject\DatasourceViewData
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
 * DTO for the datasource view data implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @SWG\Definition(type="object", required={"id", "name", "database"})
 */
class DatasourceViewData extends DatasourceOverviewData
{

    /**
     * The database information.
     *
     * @var \AppserverIo\Apps\Api\TransferObject\DatabaseOverviewData
     * @SWG\Property(property="$database", type="\AppserverIo\Apps\Api\TransferObject\DatabaseOverviewData")
     */
    protected $database;

    /**
     * Set's the database information.
     *
     * @param \AppserverIo\Apps\Api\TransferObject\DatabaseOverviewData $database The database information
     *
     * @return void
     */
    public function setDatabase(DatabaseOverviewData $database)
    {
        $this->database = $database;
    }

    /**
     * Return's the database information.
     *
     * @return \AppserverIo\Apps\Api\TransferObject\DatabaseOverviewData The database information
     */
    public function getDatabase()
    {
        return $this->database;
    }
}
