<?php

/**
 * AppserverIo\Apps\Api\Service\NamingDirectoryProcessor
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

namespace AppserverIo\Apps\Api\Service;

/**
 * A SLSB implementation providing the business logic to handle naming directories.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class NamingDirectoryProcessor extends AbstractProcessor implements NamingDirectoryProcessorInterface
{

    /**
     * The naming directory assembler instance.
     *
     * @var \AppserverIo\Apps\Api\Assembler\JsonApi\NamingDirectoryAssembler
     * @EnterpriseBean
     */
    protected $namingDirectoryAssembler;

    /**
     * Return's the naming directory assembler instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Assembler\NamingDirectoryAssemblerInterface
     */
    protected function getNamingDirectoryAssembler()
    {
        return $this->namingDirectoryAssembler;
    }

    /**
     * Returns the document representation of the naming directory with the passed ID.
     *
     * @param string $id The ID of the naming directory to be returned
     *
     * @return \Tobscure\JsonApi\Document The document representation of the naming directory
     * @see \AppserverIo\Apps\Example\Service\NamingDirectoryProcessorInterface::load()
     */
    public function load($id)
    {
        return $this->getNamingDirectoryAssembler()->getNamingDirectoryViewData($id);
    }

    /**
     * Returns the document representation of all naming directories.
     *
     * @return \Tobscure\JsonApi\Document A document representation of the naming directories
     * @see \AppserverIo\Apps\Example\Service\NamingDirectoryProcessorInterface::findAll()
     */
    public function findAll()
    {
        return $this->getNamingDirectoryAssembler()->getNamingDirectoryOverviewData();
    }
}
