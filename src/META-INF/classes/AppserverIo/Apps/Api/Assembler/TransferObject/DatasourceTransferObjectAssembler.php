<?php

/**
 * AppserverIo\Apps\Api\Assembler\TransferObject\DatasourceTransferObjectAssembler
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

namespace AppserverIo\Apps\Api\Assembler\TransferObject;

use AppserverIo\Collections\ArrayList;
use AppserverIo\Apps\Api\TransferObject\DatasourceViewData;
use AppserverIo\Apps\Api\TransferObject\DatabaseOverviewData;
use AppserverIo\Apps\Api\TransferObject\DatasourceOverviewData;
use AppserverIo\Appserver\Core\Api\Node\DatabaseNodeInterface;
use AppserverIo\Appserver\Core\Api\Node\DatasourceNodeInterface;
use AppserverIo\Apps\Api\Assembler\DatasourceAssemblerInterface;

/**
 * A SLSB implementation providing the business logic to assemble datasource nodes into DTOs.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class DatasourceTransferObjectAssembler implements DatasourceAssemblerInterface
{

    /**
     * The datasource repository instance.
     *
     * @var \AppserverIo\Apps\Api\Repository\DatasourceRepositoryInterface
     * @EnterpriseBean
     */
    protected $datasourceRepository;

    /**
     * Return's the datasource respository instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Repository\DatasourceRepositoryInterface
     */
    protected function getDatasourceRepository()
    {
        return $this->datasourceRepository;
    }

    /**
     * Convert's the passed datasource node into a DTO.
     *
     * @param \AppserverIo\Appserver\Core\Api\Node\DatasourceNodeInterface $datasourceNode The datasource node to convert
     *
     * @return \AppserverIo\Apps\Api\TransferObject\DatasourceViewData The DTO
     */
    protected function toDatasourceViewData(DatasourceNodeInterface $datasourceNode)
    {
        $viewData = new DatasourceViewData();
        $viewData->setId($datasourceNode->getPrimaryKey());
        $viewData->setName($datasourceNode->getName());
        $viewData->setDatabase($this->toDatabaseOverviewData($datasourceNode->getDatabase()));
        return $viewData;
    }

    /**
     * Convert's the passed datasource node into a DTO.
     *
     * @param \AppserverIo\Appserver\Core\Api\Node\DatasourceNodeInterface $datasourceNode The datasource node to convert
     *
     * @return \AppserverIo\Apps\Api\TransferObject\DatasourceOverviewData The DTO
     */
    protected function toDatasourceOverviewData(DatasourceNodeInterface $datasourceNode)
    {
        $overviewData = new DatasourceOverviewData();
        $overviewData->setId($datasourceNode->getPrimaryKey());
        $overviewData->setName($datasourceNode->getName());
        return $overviewData;
    }

    /**
     * Convert's the passed database node into a DTO.
     *
     * @param \AppserverIo\Appserver\Core\Api\Node\DatabaseNodeInterface $databaseNode The datgabase node to convert
     *
     * @return \AppserverIo\Apps\Api\TransferObject\DatabaseOverviewData The DTO
     */
    protected function toDatabaseOverviewData(DatabaseNodeInterface $databaseNode)
    {
        $overviewData = new DatabaseOverviewData();
        $overviewData->setId($databaseNode->getPrimaryKey());
        $overviewData->setCharset((string) $databaseNode->getCharset());
        $overviewData->setDatabaseHost((string) $databaseNode->getDatabaseHost());
        $overviewData->setDatabaseName((string) $databaseNode->getDatabaseName());
        $overviewData->setDatabasePort((integer) $databaseNode->getDatabasePort());
        $overviewData->setDriver((string) $databaseNode->getDriver());
        $overviewData->setDriverOptions((string) $databaseNode->getDriverOptions());
        $overviewData->setMemory((boolean) $databaseNode->getMemory());
        $overviewData->setPassword((string) $databaseNode->getPassword());
        $overviewData->setPath((string) $databaseNode->getPath());
        $overviewData->setUnixSocket((string) $databaseNode->getUnixSocket());
        $overviewData->setUser((string) $databaseNode->getUser());
        return $overviewData;
    }

    /**
     * Returns the a DTO with the datasource data.
     *
     * @param string $id The unique ID of the datasource to load
     *
     * @return \AppserverIo\Apps\Api\TransferObject\DatasourceViewData The DTO representation of the datasource
     * @see \AppserverIo\Apps\Api\Assembler\DatasourceAssemblerInterface::getDatasourceViewData()
     */
    public function getDatasourceViewData($id)
    {
        return $this->toDatasourceViewData($this->getDatasourceRepository()->load($id));
    }

    /**
     * Returns an ArrayList of DTOs with the datasource data.
     *
     * @return \AppserverIo\Collections\ArrayList The ArrayList with the datasource DTOs
     * @see \AppserverIo\Apps\Api\Assembler\DatasourceAssemblerInterface::getDatasourceOverviewData()
     */
    public function getDatasourceOverviewData()
    {

        // create the ArrayList instance
        $datasources = new ArrayList();

        // load all virtual host nodes
        foreach ($this->getDatasourceRepository()->findAll() as $datasourceNode) {
            $datasources->add($this->toDatasourceOverviewData($datasourceNode));
        }

        // return the ArrayList instance
        return $datasources;
    }
}
