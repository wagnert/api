<?php

/**
 * AppserverIo\Apps\Api\Service\DatasourceProcessor
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
 * A SLSB implementation providing the business logic to handle datasources.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class DatasourceProcessor extends AbstractProcessor implements DatasourceProcessorInterface
{

    /**
     * The application assembler instance.
     *
     * @var \AppserverIo\Apps\Api\Assembler\JsonApi\DatasourceAssembler
     * @EnterpriseBean
     */
    protected $datasourceAssembler;

    /**
     * The application repository instance.
     *
     * @var \AppserverIo\Apps\Api\Repository\DatasourceRepositoryInterface
     * @EnterpriseBean
     */
    protected $datasourceRepository;

    /**
     * Return's the application respository instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Assembler\ApplicationRepositoryInterface
     */
    protected function getDatasourceRepository()
    {
        return $this->datasourceRepository;
    }

    /**
     * Return's the application assembler instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Assembler\ApplicationAssemblerInterface
     */
    protected function getDatasourceAssembler()
    {
        return $this->datasourceAssembler;
    }

    /**
     * Returns the document representation of the datasource node with the passed ID.
     *
     * @param string $id The ID of the datasource node to be returned
     *
     * @return \Tobscure\JsonApi\Document The document representation of the datasource node
     * @see \AppserverIo\Apps\Example\Service\DatasourceProcessorInterface::load()
     */
    public function load($id)
    {
        return $this->getDatasourceAssembler()->getDatasourceViewData($this->getDatasourceRepository()->load($id));
    }

    /**
     * Returns the document representation of all datasource nodes.
     *
     * @return \Tobscure\JsonApi\Document A document representation of the datasource nodes
     * @see \AppserverIo\Apps\Example\Service\DatasourceProcessorInterface::findAll()
     */
    public function findAll()
    {
        return $this->getDatasourceAssembler()->getDatasourceOverviewData($this->getDatasourceRepository()->findAll());
    }
}
