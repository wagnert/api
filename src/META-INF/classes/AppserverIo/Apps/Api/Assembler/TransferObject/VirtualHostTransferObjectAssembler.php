<?php

/**
 * AppserverIo\Apps\Api\Assembler\TransferObject\VirtualHostTransferObjectAssembler
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
use AppserverIo\Apps\Api\TransferObject\VirtualHostViewData;
use AppserverIo\Apps\Api\TransferObject\VirtualHostOverviewData;
use AppserverIo\Apps\Api\Assembler\VirtualHostAssemblerInterface;
use AppserverIo\Appserver\Core\Api\Node\VirtualHostNodeInterface;

/**
 * A SLSB implementation providing the business logic to assemble virtual hosts into DTOs.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class VirtualHostTransferObjectAssembler implements VirtualHostAssemblerInterface
{

    /**
     * The virtual host repository instance.
     *
     * @var \AppserverIo\Apps\Api\Repository\VirtualHostRepositoryInterface
     * @EnterpriseBean
     */
    protected $virtualHostRepository;

    /**
     * Return's the virtual host respository instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Repository\VirtualHostRepositoryInterface
     */
    protected function getVirtualHostRepository()
    {
        return $this->virtualHostRepository;
    }

    /**
     * Convert's the passed virtual host node into a DTO.
     *
     * @param \AppserverIo\Appserver\Core\Api\Node\VirtualHostNodeInterface $virtualHostNode The virtual host node to convert
     *
     * @return \AppserverIo\Apps\Api\TransferObject\VirtualHostViewData The DTO
     */
    protected function toVirtualHostViewData(VirtualHostNodeInterface $virtualHostNode)
    {
        $viewData = new VirtualHostViewData();
        $viewData->setId($virtualHostNode->getPrimaryKey());
        $viewData->setName($virtualHostNode->getName());
        return $viewData;
    }

    /**
     * Convert's the passed virtual host node into a DTO.
     *
     * @param \AppserverIo\Appserver\Core\Api\Node\VirtualHostNodeInterface $virtualHostNode The virtual host node to convert
     *
     * @return \AppserverIo\Apps\Api\TransferObject\VirtualHostOverviewData The DTO
     */
    protected function toVirtualHostOverviewData(VirtualHostNodeInterface $virtualHostNode)
    {
        $overviewData = new VirtualHostOverviewData();
        $overviewData->setId($virtualHostNode->getPrimaryKey());
        $overviewData->setName($virtualHostNode->getName());
        return $overviewData;
    }

    /**
     * Returns the a DTO with the virtual host data.
     *
     * @param string $id The unique ID of the virtual host to load
     *
     * @return \AppserverIo\Apps\Api\TransferObject\VirtualHostViewData The DTO representation of the virtual host
     * @see \AppserverIo\Apps\Api\Assembler\VirtualHostAssemblerInterface::getVirtualHostViewData()
     */
    public function getVirtualHostViewData($id)
    {
        return $this->toVirtualHostViewData($this->getVirtualHostRepository()->load($id));
    }

    /**
     * Returns an ArrayList of DTOs with the virtual host data.
     *
     * @return \AppserverIo\Collections\ArrayList The ArrayList with the virtual host DTOs
     * @see \AppserverIo\Apps\Api\Assembler\VirtualHostAssemblerInterface::getVirtualHostOverviewData()
     */
    public function getVirtualHostOverviewData()
    {

        // create the ArrayList instance
        $virtualHosts = new ArrayList();

        // load all virtual host nodes
        foreach ($this->getVirtualHostRepository()->findAll() as $virtualHostNode) {
            $virtualHosts->add($this->toVirtualHostOverviewData($virtualHostNode));
        }

        // return the ArrayList instance
        return $virtualHosts;
    }
}
