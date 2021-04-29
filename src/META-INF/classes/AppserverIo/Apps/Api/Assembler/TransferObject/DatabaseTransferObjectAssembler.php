<?php

/**
 * AppserverIo\Apps\Api\Assembler\TransferObject\DatabaseTransferObjectAssembler
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

use AppserverIo\Apps\Api\TransferObject\DatabaseOverviewData;
use AppserverIo\Apps\Api\Assembler\DatabaseAssemblerInterface;
use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;
use AppserverIo\Psr\ApplicationServer\Configuration\DatabaseConfigurationInterface;

/**
 * A SLSB implementation providing the business logic to assemble database nodes into DTOs.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @EPB\Stateless
 */
class DatabaseTransferObjectAssembler implements DatabaseAssemblerInterface
{

    /**
     * Convert's the passed database node into a DTO.
     *
     * @param \AppserverIo\Psr\ApplicationServer\Configuration\DatabaseConfigurationInterface $databaseNode The datgabase node to convert
     *
     * @return \AppserverIo\Apps\Api\TransferObject\DatabaseOverviewData The DTO
     */
    public function toDatabaseOverviewData(DatabaseConfigurationInterface $databaseNode)
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
     * Returns the a DTO with the database data.
     *
     * @param string $id The unique ID of the database to load
     *
     * @return \AppserverIo\Apps\Api\TransferObject\DatabaseViewData The DTO representation of the database
     * @see \AppserverIo\Apps\Api\Assembler\DatabaseAssemblerInterface::getDatabaseViewData()
     */
    public function getDatabaseViewData($id)
    {
    }

    /**
     * Returns an ArrayList of DTOs with the database data.
     *
     * @return \AppserverIo\Collections\ArrayList The ArrayList with the database DTOs
     * @see \AppserverIo\Apps\Api\Assembler\DatabaseAssemblerInterface::getDatabaseOverviewData()
     */
    public function getDatabaseOverviewData()
    {
    }
}
