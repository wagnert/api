<?php

/**
 * AppserverIo\Apps\Api\Service\AbstractPersistenceProcessor
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

use AppserverIo\Psr\EnterpriseBeans\Annotations as EPB;

/**
 * Abstract processor implementation that provides a Doctrine ORM entity manager.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
abstract class AbstractPersistenceProcessor extends AbstractProcessor
{

    /**
     * The Doctrine EntityManager instance.
     *
     * @var \Doctrine\ORM\EntityManagerInterface
     * @EPB\PersistenceUnit(unitName="ApiEntityManager")
     */
    protected $entityManager;

    /**
     * Return's the initialized Doctrine entity manager.
     *
     * @return \Doctrine\ORM\EntityManagerInterface The initialized Doctrine entity manager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Close the entity manager's connection before destroying the bean.
     *
     * @return void
     * @EPB\PreDestroy
     */
    public function preDestroy()
    {
        $this->getEntityManager()->getConnection()->close();
    }

    /**
     * Close the entity manager's connection before re-attaching it to the container.
     *
     * @return void
     * @EPB\PreAttach
     */
    public function preAttach()
    {
        $this->getEntityManager()->getConnection()->close();
    }
}
