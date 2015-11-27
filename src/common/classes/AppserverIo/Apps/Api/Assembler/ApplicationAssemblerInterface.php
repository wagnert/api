<?php

/**
 * AppserverIo\Apps\Api\Assembler\ApplicationAssemblerInterface
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

use AppserverIo\Psr\Application\ApplicationInterface;

/**
 * Interface for application assemblers.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
interface ApplicationAssemblerInterface
{

    /**
     * Returns the a new JSON-API document with the application data.
     *
     * @param \AppserverIo\Psr\Application\ApplicationInterface $application The application to assemble
     *
     * @return \Tobscure\JsonApi\Document The document representation of the application
     */
    public function getApplicationViewData(ApplicationInterface $application);

    /**
     * Returns the a new JSON-API document with the application array as the data.
     *
     * @param array $applications The array with the applications to assemble
     *
     * @return Tobscure\JsonApi\Document The document representation of the applications
     */
    public function getApplicationOverviewData(array $applications);
}
