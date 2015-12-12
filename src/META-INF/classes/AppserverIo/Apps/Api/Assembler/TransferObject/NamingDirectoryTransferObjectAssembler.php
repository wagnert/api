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

use AppserverIo\Psr\NamingDirectory\NamingDirectoryInterface;
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
     * Returns the a new JSON-API document with the naming directory data.
     *
     * @param AppserverIo\Psr\NamingDirectory\NamingDirectoryInterface $namingDirectory The naming directory to assemble
     *
     * @return \Tobscure\JsonApi\Document The document representation of the naming directory
     * @see \AppserverIo\Apps\Api\Assembler\NamingDirectoryAssemblerInterface::getNamingDirectoryViewData()
     */
    public function getNamingDirectoryViewData(NamingDirectoryInterface $namingDirectory)
    {
    }

    /**
     * Returns the a new JSON-API document with the naming directory array as the data.
     *
     * @param array $namingDirectories The array with the naming directories to assemble
     *
     * @return Tobscure\JsonApi\Document The document representation of the naming directories
     * @see \AppserverIo\Apps\Api\Assembler\NamingDirectoryAssemblerInterface::getNamingDirectoryOverviewData()
     */
    public function getNamingDirectoryOverviewData(array $namingDirectories)
    {
    }
}
