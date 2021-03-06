<?php

/**
 * AppserverIo\Apps\Api\Provisioning\PrepareDatabaseStep
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
 * @link      https://github.com/appserver-io/api
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Apps\Api\Provisioning;

use AppserverIo\Provisioning\Steps\AbstractStep;
use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;

/**
 * An step implementation that creates a database and login credentials
 * based on the specified datasource.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/api
 * @link      http://www.appserver.io
 *
 * @EPB\Inject(shared=false)
 */
class PrepareDatabaseStep extends AbstractStep
{

    /**
     * The schema processor instance.
     *
     * @var \AppserverIo\Apps\Api\Service\SchemaProcessor
     * @EPB\EnterpriseBean
     */
    protected $schemaProcessor;

    /**
     * Executes the functionality for this step, in this case the execution of
     * the PHP script defined in the step configuration.
     *
     * @return void
     * @throws \Exception Is thrown if the script can't be executed
     * @see \AppserverIo\Appserver\Core\Provisioning\StepInterface::execute()
     */
    public function execute()
    {

        try {
            // log a message that provisioning starts
            $this->getApplication()->getInitialContext()->getSystemLogger()->info(
                'Now start to prepare database using SchemaProcessor!'
            );

            // create schema, default products + login credentials
            $this->schemaProcessor->createSchema();
            $this->schemaProcessor->createDefaultCredentials();

            // log a message that provisioning has been successfull
            $this->getApplication()->getInitialContext()->getSystemLogger()->info(
                'Successfully prepared database using SchemaProcessor!'
            );

        } catch (\Exception $e) {
            $this->getApplication()->getInitialContext()->getSystemLogger()->error($e->__toString());
        }
    }
}
