<?php

/**
 * AppserverIo\Apps\Api\Assembler\PersistenceUnitAssemblerInterface
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
 * Interface for persistence unit assemblers.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
interface PersistenceUnitAssemblerInterface
{

    /**
     * Returns the persistence unit data.
     *
     * @param string $id The unique ID of the persistence unit to load
     *
     * @return mixed The persistence unit representation
     */
    public function getPersistenceUnitViewData($id);

    /**
     * Returns the persistence units.
     *
     * @return mixed The persistence units representation
     */
    public function getPersistenceUnitOverviewData();
}
