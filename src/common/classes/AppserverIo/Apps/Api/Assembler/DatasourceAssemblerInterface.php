<?php

/**
 * AppserverIo\Apps\Api\Assembler\DatasourceAssemblerInterface
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

namespace AppserverIo\Apps\Api\Assembler;

use AppserverIo\Appserver\Core\Api\Node\DatasourceNodeInterface;

/**
 * Interface for datasource assemblers.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
interface DatasourceAssemblerInterface
{

    /**
     * Returns the a new JSON-API document with the datasource node data.
     *
     * @param \AppserverIo\Appserver\Core\Api\DatasourceNodeInterface $datasourceNode The datasource node to assemble
     *
     * @return \Tobscure\JsonApi\Document The document representation of the datasource node
     */
    public function getDatasourceViewData(DatasourceNodeInterface $datasourceNode);

    /**
     * Returns the a new JSON-API document with the datasource node array as the data.
     *
     * @param array $datasourceNodes The array with the datasource nodes to assemble
     *
     * @return Tobscure\JsonApi\Document The document representation of the datasource nodes
     */
    public function getDatasourceOverviewData(array $datasourceNodes);
}
