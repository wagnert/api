<?php

/**
 * AppserverIo\Apps\Api\Service\VirtualHostProcessor
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
 * A SLSB implementation providing the business logic to handle virtual hosts.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class VirtualHostProcessor extends AbstractProcessor implements DatasourceProcessorInterface
{

    /**
     * The virtual host assembler instance.
     *
     * @var \AppserverIo\Apps\Api\Assembler\JsonApi\VirtualHostAssembler
     * @EnterpriseBean
     */
    protected $virtualHostAssembler;

    /**
     * Return's the virtual host assembler instance.
     *
     * @return \AppserverIo\RemoteMethodInvocation\RemoteProxy The assembler instance
     * @see \AppserverIo\Apps\Api\Assembler\VirtualHostAssemblerInterface
     */
    protected function getVirtualHostAssembler()
    {
        return $this->virtualHostAssembler;
    }

    /**
     * Returns the document representation of the virtual host node with the passed ID.
     *
     * @param string $id The ID of the virtual host node to be returned
     *
     * @return \Tobscure\JsonApi\Document The document representation of the virtual host node
     * @see \AppserverIo\Apps\Example\Service\VirtualHostProcessorInterface::load()
     */
    public function load($id)
    {
        return $this->getVirtualHostAssembler()->getVirtualHostViewData($id);
    }

    /**
     * Returns the document representation of all virtual host nodes.
     *
     * @return \Tobscure\JsonApi\Document A document representation of the virtual host nodes
     * @see \AppserverIo\Apps\Example\Service\VirtualHostProcessorInterface::findAll()
     */
    public function findAll()
    {
        return $this->getVirtualHostAssembler()->getVirtualHostOverviewData();
    }
}
