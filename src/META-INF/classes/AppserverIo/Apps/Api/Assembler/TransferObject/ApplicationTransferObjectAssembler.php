<?php

/**
 * AppserverIo\Apps\Api\Assembler\TransferObject\ApplicationTransferObjectAssembler
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
use AppserverIo\Appserver\Core\Api\Node\AppNodeInterface;
use AppserverIo\Apps\Api\TransferObject\ApplicationViewData;
use AppserverIo\Apps\Api\TransferObject\ApplicationOverviewData;
use AppserverIo\Apps\Api\Assembler\ApplicationAssemblerInterface;

/**
 * A SLSB implementation providing the business logic to assemble applications into DTOs.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class ApplicationTransferObjectAssembler implements ApplicationAssemblerInterface
{

    /**
     * The application repository instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy
     * @see \AppserverIo\Apps\Api\Repository\ApplicationRepositoryInterface
     * @EnterpriseBean
     */
    protected $applicationRepository;

    /**
     * Return's the application respository instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Repository\ApplicationRepositoryInterface
     */
    public function getApplicationRepository()
    {
        return $this->applicationRepository;
    }

    /**
     * Convert's the passed application into a DTO.
     *
     * @param \AppserverIo\Appserver\Core\Api\Node\AppNodeInterface $appNode The application node to convert
     *
     * @return \AppserverIo\Apps\Api\TransferObject\ApplicationViewData The DTO
     */
    public function toApplicationViewData(AppNodeInterface $appNode)
    {
        $viewData = new ApplicationViewData();
        $viewData->setId($appNode->getPrimaryKey());
        $viewData->setName($appNode->getName());
        $viewData->setWebappPath($appNode->getWebappPath());
        return $viewData;
    }

    /**
     * Convert's the passed application into a DTO.
     *
     * @param \AppserverIo\Appserver\Core\Api\Node\AppNodeInterface $appNode The application node to convert
     *
     * @return \AppserverIo\Apps\Api\TransferObject\ApplicationOverviewData The DTO
     */
    public function toApplicationOverviewData(AppNodeInterface $appNode)
    {
        $overviewData = new ApplicationOverviewData();
        $overviewData->setId($appNode->getPrimaryKey());
        $overviewData->setName($appNode->getName());
        $overviewData->setWebappPath($appNode->getWebappPath());
        return $overviewData;
    }

    /**
     * Returns the a DTO with the application data.
     *
     * @param string $id The unique ID of the application to load
     *
     * @return \AppserverIo\Apps\Api\TransferObject\ApplicationViewData The DTO representation of the application
     * @see \AppserverIo\Apps\Api\Assembler\ApplicationAssemblerInterface::getApplicationViewData()
     */
    public function getApplicationViewData($id)
    {
        return $this->toApplicationViewData($this->getApplicationRepository()->load($id));
    }

    /**
     * Returns an ArrayList of DTOs with the application data.
     *
     * @return \AppserverIo\Collections\ArrayList The ArrayList with the application DTOs
     * @see \AppserverIo\Apps\Api\Assembler\ApplicationAssemblerInterface::getApplicationOverviewData()
     */
    public function getApplicationOverviewData()
    {

        // create the ArrayList instance
        $applications = new ArrayList();

        // load all applications
        foreach ($this->getApplicationRepository()->findAll() as $application) {
            $applications->add($this->toApplicationOverviewData($application));
        }

        // return the ArrayList instance
        return $applications;
    }
}
