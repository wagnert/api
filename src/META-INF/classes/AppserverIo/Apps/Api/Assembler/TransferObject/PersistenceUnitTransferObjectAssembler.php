<?php

/**
 * AppserverIo\Apps\Api\Assembler\TransferObject\PersistenceUnitTransferObjectAssembler
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
use AppserverIo\Apps\Api\TransferObject\PersistenceUnitViewData;
use AppserverIo\Apps\Api\TransferObject\PersistenceUnitOverviewData;
use AppserverIo\Apps\Api\Assembler\PersistenceUnitAssemblerInterface;
use AppserverIo\Description\Configuration\PersistenceUnitConfigurationInterface;
use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;

/**
 * A SLSB implementation providing the business logic to assemble persistence units into DTOs.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @EPB\Stateless
 */
class PersistenceUnitTransferObjectAssembler implements PersistenceUnitAssemblerInterface
{

    /**
     * The persistence unit repository instance.
     *
     * @var \AppserverIo\Apps\Api\Repository\PersistenceRepositoryInterface
     * @EPB\EnterpriseBean
     */
    protected $persistenceUnitRepository;

    /**
     * The datasource repository instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Assembler\DatasourceAssemblerInterface
     * @EPB\EnterpriseBean
     */
    protected $datasourceTransferObjectAssembler;

    /**
     * Return's the persistence unit respository instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Repository\PersistenceUnitRepositoryInterface
     */
    public function getPersistenceUnitRepository()
    {
        return $this->persistenceUnitRepository;
    }

    /**
     * Return's the assembler instance.
     *
     * @return AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Assembler\DatasourceAssemblerInterface
     */
    public function getDatasourceTransferObjectAssembler()
    {
        return $this->datasourceTransferObjectAssembler;
    }

    /**
     * Convert's the passed persistence unit node into a DTO.
     *
     * @param \AppserverIo\Description\Configuration\PersistenceUnitConfigurationInterface $persistenceUnitNode The persistence unit node to convert
     *
     * @return \AppserverIo\Apps\Api\TransferObject\PersistenceUnitViewData The DTO
     */
    public function toPersistenceUnitViewData(PersistenceUnitConfigurationInterface $persistenceUnitNode)
    {
        $viewData = new PersistenceUnitViewData();
        $viewData->setId($persistenceUnitNode->getPrimaryKey());
        $viewData->setName($persistenceUnitNode->getName());
        $viewData->setDatasource($this->getDatasourceTransferObjectAssembler()->toDatasourceOverviewData($persistenceUnitNode->getDatasource()));
        return $viewData;
    }

    /**
     * Convert's the passed persistence unit node into a DTO.
     *
     * @param \c $persistenceUnitNode The persistence unit node to convert
     *
     * @return \AppserverIo\Apps\Api\TransferObject\PersistenceUnitOverviewData The DTO
     */
    public function toPersistenceUnitOverviewData(PersistenceUnitConfigurationInterface $persistenceUnitNode)
    {
        $overviewData = new PersistenceUnitOverviewData();
        $overviewData->setId($persistenceUnitNode->getPrimaryKey());
        $overviewData->setName($persistenceUnitNode->getName());
        return $overviewData;
    }

    /**
     * Returns the a DTO with the persistence unit data.
     *
     * @param string $id The unique ID of the persistence unit to load
     *
     * @return \AppserverIo\Apps\Api\TransferObject\PersistenceUnitViewData The DTO representation of the persistence unit
     * @see \AppserverIo\Apps\Api\Assembler\PersistenceUnitAssemblerInterface::getPersistenceUnitViewData()
     */
    public function getPersistenceUnitViewData($id)
    {
        return $this->toPersistenceUnitViewData($this->getPersistenceUnitRepository()->load($id));
    }

    /**
     * Returns an ArrayList of DTOs with the persistence unit data.
     *
     * @return \AppserverIo\Collections\ArrayList The ArrayList with the persistence unit DTOs
     * @see \AppserverIo\Apps\Api\Assembler\PersistenceUnitAssemblerInterface::getPersistenceUnitOverviewData()
     */
    public function getPersistenceUnitOverviewData()
    {

        // create the ArrayList instance
        $persistenceUnitNodes = new ArrayList();

        // load all persistence unit nodes
        foreach ($this->getPersistenceUnitRepository()->findAll() as $persistenceUnitNode) {
            $persistenceUnitNodes->add($this->toPersistenceUnitOverviewData($persistenceUnitNode));
        }

        // return the ArrayList instance
        return $persistenceUnitNodes;
    }
}
