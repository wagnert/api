<?php

/**
 * AppserverIo\Apps\Api\Service\ContainerProcessor
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
 * A SLSB implementation providing the business logic to handle containers.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class ContainerProcessor extends AbstractProcessor implements ContainerProcessorInterface
{

    /**
     * The container assembler instance.
     *
     * @var \AppserverIo\Apps\Api\Assembler\JsonApi\ContainerAssembler
     * @EnterpriseBean
     */
    protected $containerAssembler;

    /**
     * The container repository instance.
     *
     * @var \AppserverIo\Apps\Api\Repository\ContainerRepositoryInterface
     * @EnterpriseBean
     */
    protected $containerRepository;

    /**
     * Return's the container respository instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Repository\ContainerRepositoryInterface
     */
    protected function getContainerRepository()
    {
        return $this->containerRepository;
    }

    /**
     * Return's the container assembler instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Assembler\ContainerAssemblerInterface
     */
    protected function getContainerAssembler()
    {
        return $this->containerAssembler;
    }

    /**
     * Returns the document representation of the container node with the passed ID.
     *
     * @param string $id The ID of the container node to be returned
     *
     * @return \Tobscure\JsonApi\Document The document representation of the container node
     * @see \AppserverIo\Apps\Example\Service\ContainerProcessorInterface::load()
     */
    public function load($id)
    {
        return $this->getContainerAssembler()->getContainerViewData($this->getContainerRepository()->load($id));
    }

    /**
     * Returns the document representation of all container nodes.
     *
     * @return \Tobscure\JsonApi\Document A document representation of the container nodes
     * @see \AppserverIo\Apps\Example\Service\ContainerProcessorInterface::findAll()
     */
    public function findAll()
    {
        return $this->getContainerAssembler()->getContainerOverviewData($this->getContainerRepository()->findAll());
    }
}
