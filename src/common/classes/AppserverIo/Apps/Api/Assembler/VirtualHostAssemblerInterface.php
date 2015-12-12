<?php

/**
 * AppserverIo\Apps\Api\Assembler\VirtualHostAssemblerInterface
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

namespace AppserverIo\Apps\Api\Assembler;

use AppserverIo\Appserver\Core\Api\Node\VirtualHostNodeInterface;

/**
 * Interface for virtual host assemblers.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
interface VirtualHostAssemblerInterface
{

    /**
     * Returns the a new JSON-API document with the virtual host data.
     *
     * @param \AppserverIo\Appserver\Core\Api\Node\VirtualHostNode $virtualHostNode The virtual host to assemble
     *
     * @return \Tobscure\JsonApi\Document The document representation of the virtual host
     * @see \AppserverIo\Apps\Api\Assembler\VirtualHostAssemblerInterface::getVirtualHostViewData()
     */
    public function getVirtualHostViewData($id);

    /**
     * Returns the a new JSON-API document with the virtual host array as the data.
     *
     * @return \Tobscure\JsonApi\Document The document representation of the virtual hosts
     * @see \AppserverIo\Apps\Api\Assembler\VirtualHostAssemblerInterface::getVirtualHostOverviewData()
     */
    public function getVirtualHostOverviewData();
}
