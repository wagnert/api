<?php

/**
 * AppserverIo\Apps\Api\Service\PersistenceUnitProcessor
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

use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;

/**
 * A SLSB implementation providing the business logic to handle
 * persistence units.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @EPB\Stateless
 */
class PersistenceUnitProcessor extends AbstractProcessor implements PersistenceUnitProcessorInterface
{

    /**
     * The persistence unit assembler instance.
     *
     * @var \AppserverIo\Apps\Api\Assembler\JsonApi\PersistenceUnitAssembler
     *
     * @EPB\EnterpriseBean
     */
    protected $persistenceUnitAssembler;

    /**
     * The persistence unit repository instance.
     *
     * @var \AppserverIo\Apps\Api\Repository\PersistenceUnitRepositoryInterface
     *
     * @EPB\EnterpriseBean
     */
    protected $persistenceUnitRepository;

    /**
     * Return's the persistence unit respository instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Repository\PersistenceUnitRepositoryInterface
     */
    protected function getPersistenceUnitRepository()
    {
        return $this->persistenceUnitRepository;
    }

    /**
     * Return's the persistence unit assembler instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Assembler\PersistenceUnitAssemblerInterface
     */
    protected function getPersistenceUnitAssembler()
    {
        return $this->persistenceUnitAssembler;
    }

    /**
     * Returns the document representation of the persistence unit with the passed ID.
     *
     * @param string $id The ID of the persistence unit to be returned
     *
     * @return \Tobscure\JsonApi\Document The document representation of the persistence unit
     * @see \AppserverIo\Apps\Example\Service\PersistenceUnitProcessorInterface::load()
     */
    public function load($id)
    {
        return $this->getPersistenceUnitAssembler()->getPersistenceUnitViewData($id);
    }

    /**
     * Returns the document representation of all persistence units.
     *
     * @return \Tobscure\JsonApi\Document A document representation of the persistence units
     * @see \AppserverIo\Apps\Example\Service\PersistenceUnitProcessorInterface::findAll()
     */
    public function findAll()
    {
        return $this->getPersistenceUnitAssembler()->getPersistenceUnitOverviewData();
    }

    /**
     * Returns the document representation of all persistence units
     * of the application with the passed name.
     *
     * @param string $applicationName The name of the application to return the persistence units for
     *
     * @return \Tobscure\JsonApi\Document A document representation of the persistence units
     * @see \AppserverIo\Apps\Example\Service\PersistenceUnitProcessorInterface::findAll()
     */
    public function findAllByApplicationName($applicationName)
    {
        return $this->getPersistenceUnitAssembler()->getPersistenceUnitOverviewDataByApplicationName($applicationName);
    }
}
