<?php

/**
 * AppserverIo\Apps\Api\Assembler\TransferObject\ContainerTransferObjectAssembler
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
use AppserverIo\Apps\Api\TransferObject\ContainerViewData;
use AppserverIo\Apps\Api\TransferObject\ContainerOverviewData;
use AppserverIo\Apps\Api\Assembler\ContainerAssemblerInterface;
use AppserverIo\Appserver\Core\Api\Node\ContainerNodeInterface;

/**
 * A SLSB implementation providing the business logic to assemble containers into DTOs.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class ContainerTransferObjectAssembler implements ContainerAssemblerInterface
{

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
     * Convert's the passed container node into a DTO.
     *
     * @param \AppserverIo\Appserver\Core\Api\Node\ContainerNodeInterface $virtualHostNode The container node to convert
     *
     * @return \AppserverIo\Apps\Api\TransferObject\ContainerViewData The DTO
     */
    protected function toContainerViewData(ContainerNodeInterface $containerNode)
    {
        $viewData = new ContainerViewData();
        $viewData->setId($containerNode->getPrimaryKey());
        $viewData->setName($containerNode->getName());
        return $viewData;
    }

    /**
     * Convert's the passed container node into a DTO.
     *
     * @param \AppserverIo\Appserver\Core\Api\Node\ContainerNodeInterface $containerNode The container node to convert
     *
     * @return \AppserverIo\Apps\Api\TransferObject\ContainerOverviewData The DTO
     */
    protected function toContainerOverviewData(ContainerNodeInterface $containerNode)
    {
        $overviewData = new ContainerOverviewData();
        $overviewData->setId($containerNode->getPrimaryKey());
        $overviewData->setName($containerNode->getName());
        return $overviewData;
    }

    /**
     * Returns the a DTO with the container data.
     *
     * @param string $id The unique ID of the container to load
     *
     * @return \AppserverIo\Apps\Api\TransferObject\ContainerViewData The DTO representation of the container
     * @see \AppserverIo\Apps\Api\Assembler\ContainerAssemblerInterface::getContainerViewData()
     */
    public function getContainerViewData($id)
    {
        return $this->toContainerViewData($this->getContainerRepository()->load($id));
    }

    /**
     * Returns an ArrayList of DTOs with the container data.
     *
     * @return \AppserverIo\Collections\ArrayList The ArrayList with the container DTOs
     * @see \AppserverIo\Apps\Api\Assembler\ContainerAssemblerInterface::getContainerOverviewData()
     */
    public function getContainerOverviewData()
    {

        // create the ArrayList instance
        $containers = new ArrayList();

        // load all virtual host nodes
        foreach ($this->getContainerRepository()->findAll() as $containerNode) {
            $containers->add($this->toContainerOverviewData($containerNode));
        }

        // return the ArrayList instance
        return $containers;
    }
}
