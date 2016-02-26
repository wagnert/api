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
     * Returns the virtual host data.
     *
     * @param string $id The unique ID of the virtual host to load
     *
     * @return mixed The virtual host representation
     */
    public function getVirtualHostViewData($id);

    /**
     * Returns the virtual hosts.
     *
     * @return mixed The virtual hosts representation
     */
    public function getVirtualHostOverviewData();
}
