<?php

/**
 * AppserverIo\Apps\Api\Assembler\JsonApi\DatasourceAssembler
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

use Tobscure\JsonApi\Resource;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Collection;
use AppserverIo\Apps\Api\Assembler\DatasourceAssemblerInterface;
use AppserverIo\Apps\Api\Serializer\DatasourceSerializer;
use AppserverIo\Appserver\Core\Api\DatasourceNodeInterface;

/**
 * A SLSB implementation providing the business logic to assemble datasource nodes
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
class DatasourceAssembler implements DatasourceAssemblerInterface
{

    /**
     * Returns the a new JSON-API document with the datasource node data.
     *
     * @param \AppserverIo\Appserver\Core\Api\DatasourceNodeInterface $datasourceNode The datasource node to assemble
     *
     * @return \Tobscure\JsonApi\Document The document representation of the datasource node
     * @see \AppserverIo\Apps\Api\Assembler\DatasourceAssemblerInterface::getDatasourceViewData()
     */
    public function getDatasourceViewData(DatasourceNodeInterface $datasourceNode)
    {
        return new Document((new Resource($datasourceNode, new DatasourceSerializer()))->with(['database']));
    }

    /**
     * Returns the a new JSON-API document with the datasource node array as the data.
     *
     * @param array $datasourceNodes The array with the datasource nodes to assemble
     *
     * @return Tobscure\JsonApi\Document The document representation of the datasource nodes
     * @see \AppserverIo\Apps\Api\Assembler\DatasourceAssemblerInterface::getDatasourceOverviewData()
     */
    public function getDatasourceOverviewData(array $datasourceNodes)
    {

        // create a new collection of datasources
        $collection = (new Collection($datasourceNodes, new DatasourceSerializer()))->with(['database']);

        // create a new JSON-API document with that collection as the data
        $document = new Document($collection);

        // add metadata and links.
        $document->addMeta('total', count($datasourceNodes));

        // return the stdClass representation of the datasources
        return $document;
    }
}
