<?php

/**
 * AppserverIo\Apps\Api\Assembler\TransferObject\NamingDirectoryTransferObjectAssembler
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
use AppserverIo\Psr\Naming\NamingDirectoryInterface;
use AppserverIo\Apps\Api\TransferObject\NamingDirectoryViewData;
use AppserverIo\Apps\Api\TransferObject\NamingDirectoryOverviewData;
use AppserverIo\Apps\Api\Assembler\NamingDirectoryAssemblerInterface;

/**
 * A SLSB implementation providing the business logic to assemble naming directories into DTOs.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class NamingDirectoryTransferObjectAssembler implements NamingDirectoryAssemblerInterface
{

    /**
     * The datasource repository instance.
     *
     * @var \AppserverIo\Apps\Api\Repository\NamingDirectoryRepositoryInterface
     * @EnterpriseBean
     */
    protected $namingDirectoryRepository;

    /**
     * Return's the naming directory respository instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Repository\NamingDirectoryRepositoryInterface
     */
    public function getNamingDirectoryRepository()
    {
        return $this->namingDirectoryRepository;
    }

    /**
     * Convert's the passed naming directory into a DTO.
     *
     * @param \AppserverIo\Psr\Naming\NamingDirectoryInterface $namingDirectory The naming directory to convert
     *
     * @return \AppserverIo\Apps\Api\TransferObject\NamingDirectoryViewData The DTO
     */
    public function toNamingDirectoryViewData(NamingDirectoryInterface $namingDirectory)
    {
        $viewData = new NamingDirectoryViewData();
        $viewData->setId($namingDirectory->getSerial());
        $viewData->setName($namingDirectory->getName());
        $viewData->setScheme($namingDirectory->getScheme());
        $viewData->setValues($namingDirectory->toArray());
        return $viewData;
    }

    /**
     * Convert's the passed naming directory into a DTO.
     *
     * @param \AppserverIo\Psr\Naming\NamingDirectoryInterface $namingDirectory The naming directory to convert
     *
     * @return \AppserverIo\Apps\Api\TransferObject\NamingDirectoryOverviewData The DTO
     */
    public function toNamingDirectoryOverviewData(NamingDirectoryInterface $namingDirectory)
    {
        $overviewData = new NamingDirectoryOverviewData();
        $overviewData->setId($namingDirectory->getSerial());
        $overviewData->setName($namingDirectory->getName());
        $overviewData->setScheme($namingDirectory->getScheme());
        return $overviewData;
    }

    /**
     * Returns the a DTO with the naming directory data.
     *
     * @param string $id The unique ID of the naming directory to load
     *
     * @return \AppserverIo\Apps\Api\TransferObject\NamingDirectoryViewData The DTO representation of the naming directory
     * @see \AppserverIo\Apps\Api\Assembler\NamingDirectoryAssemblerInterface::getNamingDirectoryViewData()
     */
    public function getNamingDirectoryViewData($id)
    {
        return $this->toNamingDirectoryViewData($this->getNamingDirectoryRepository()->load($id));
    }

    /**
     * Returns an ArrayList of DTOs with the naming directory data.
     *
     * @return \AppserverIo\Collections\ArrayList The ArrayList with the naming directory DTOs
     * @see \AppserverIo\Apps\Api\Assembler\NamingDirectoryAssemblerInterface::getNamingDirectoryOverviewData()
     */
    public function getNamingDirectoryOverviewData()
    {

        // create the ArrayList instance
        $namingDirectories = new ArrayList();

        // load all virtual host nodes
        foreach ($this->getNamingDirectoryRepository()->findAll() as $namingDirectory) {
            $namingDirectories->add($this->toNamingDirectoryOverviewData($namingDirectory));
        }

        // return the ArrayList instance
        return $namingDirectories;
    }
}
