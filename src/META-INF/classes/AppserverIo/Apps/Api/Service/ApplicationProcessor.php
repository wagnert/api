<?php

/**
 * AppserverIo\Apps\Api\Service\ApplicationProcessor
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
 * A SLSB implementation providing the business logic to handle applications.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class ApplicationProcessor extends AbstractProcessor implements ApplicationProcessorInterface
{

    /**
     * The application assembler instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy The application assembler instance
     * @see \AppserverIo\Apps\Api\Assembler\ApplicationAssemblerInterface
     *
     * @EnterpriseBean
     */
    protected $applicationAssembler;

    /**
     * The application repository instance.
     *
     * @var \AppserverIo\RemoteMethodInvocation\RemoteProxy The application repository instance
     * @see \AppserverIo\Apps\Example\Repository\ApplicationRepositoryInterface
     *
     * @EnterpriseBean
     */
    protected $applicationRepository;

    /**
     * Return's the application assembler instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Assembler\ApplicationAssemblerInterface
     */
    protected function getApplicationAssembler()
    {
        return $this->applicationAssembler;
    }

    /**
     * Return's the application respository instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Repository\ApplicationRepositoryInterface
     */
    protected function getApplicationRepository()
    {
        return $this->applicationRepository;
    }

    /**
     * Returns the document representation of the application with the passed ID.
     *
     * @param string $id The ID of the application to be returned
     *
     * @return \Tobscure\JsonApi\Document The document representation of the application
     * @see \AppserverIo\Apps\Example\Service\ApplicationProcessorInterface::load()
     */
    public function load($id)
    {
        return $this->getApplicationAssembler()->getApplicationViewData($id);
    }

    /**
     * Returns the document representation of all applications.
     *
     * @return \Tobscure\JsonApi\Document A document representation of the applications
     * @see \AppserverIo\Apps\Example\Service\ApplicationProcessorInterface::findAll()
     */
    public function findAll()
    {
        return $this->getApplicationAssembler()->getApplicationOverviewData();
    }

    /**
     * Returns the path to the thumbnail image of the app with the
     * passed ID.
     *
     * @param string $id ID of the app to return the thumbnail for
     *
     * @return string The absolute path the thumbnail
     * @see \AppserverIo\Apps\Example\Service\ApplicationProcessorInterface::thumbnail()
     */
    public function thumbnail($id)
    {
        return $this->getApplicationRepository()->thumbnail($id);
    }

    /**
     * Uploads the passed file to the application servers deploy directory.
     *
     * @param string $containerId The ID of the container to deploy the PHAR archive to
     * @param string $filename    The filename
     *
     * @return void
     * @see \AppserverIo\Apps\Example\Service\ApplicationProcessorInterface::upload()
     */
    public function upload($containerId, $filename)
    {
        $this->getApplicationRepository()->upload($containerId, $filename);
    }

    /**
     * Deletes the app node with the passed ID from the system configuration.
     *
     * @param string $id The ID of the app node to delete
     *
     * @return void
     * @see \AppserverIo\Apps\Example\Service\ApplicationProcessorInterface::delete()
     */
    public function delete($id)
    {
        $this->getApplicationRepository()->delete($id);
    }
}
