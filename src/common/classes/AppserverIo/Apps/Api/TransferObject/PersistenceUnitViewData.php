<?php

/**
 * AppserverIo\Apps\Api\TransferObject\PersistenceUnitViewData
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
 * DTO for the persistence unit view data implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @SWG\Definition(type="object", required={"id", "name", "datasource"})
 */
class PersistenceUnitViewData extends PersistenceUnitOverviewData
{

    /**
     * The persistence unit datasource.
     *
     * @var \AppserverIo\Apps\Api\TransferObject\DatasourceOverviewData
     * @SWG\Property(property="datasource", type="\AppserverIo\Apps\Api\TransferObject\DatasourceOverviewData")
     */
    protected $datasource;

    /**
     * Set's the persistence unit's datasource.
     *
     * @param \AppserverIo\Apps\Api\TransferObject\DatasourceOverviewData $datasource The persistence unit's datasource
     *
     * @return void
     */
    public function setDatasource($datasource)
    {
        $this->datasource = $datasource;
    }

    /**
     * Return's the persistence unit's datasource.
     *
     * @return \AppserverIo\Apps\Api\TransferObject\DatasourceOverviewData The persistence unit's datasource
     */
    public function getDatasource()
    {
        return $this->datasource;
    }
}
