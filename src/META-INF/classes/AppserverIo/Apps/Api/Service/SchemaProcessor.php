<?php

/**
 * AppserverIo\Apps\Api\Service\SchemaProcessor
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

use Doctrine\ORM\Tools\SchemaTool;
use AppserverIo\Collections\ArrayList;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * A singleton session bean implementation that handles the
 * schema data for Doctrine by using Doctrine ORM itself.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class SchemaProcessor extends AbstractPersistenceProcessor implements SchemaProcessorInterface
{

    /**
     * The DIC provider instance.
     *
     * @var \AppserverIo\Appserver\DependencyInjectionContainer\Interfaces\ProviderInterface $provider
     * @Resource(name="ProviderInterface")
     */
    protected $providerInterface;

    /**
     * A list with default credentials for login testing.
     *
     * @var array
     */
    protected $users = array(
        array('appserver', 'info@appserver.io', 'en_US', 'appserver.i0', array('Administrator')),
        array('manager', 'info@appserver.io', 'en_US', 'appserver.i0', array('Manager')),
        array('guest', 'info@appserver.io', 'en_US', 'appserver.i0', array('Guest'))
    );

    /**
     * Example method that should be invoked after constructor.
     *
     * @return void
     * @PostConstruct
     */
    public function initialize()
    {
        $this->getInitialContext()->getSystemLogger()->info(
            sprintf('%s has successfully been invoked by @PostConstruct annotation', __METHOD__)
        );
    }

    /**
     * Deletes the database schema and creates it new.
     *
     * Attention: All data will be lost if this method has been invoked.
     *
     * @return void
     */
    public function createSchema()
    {

        // load the entity manager and the schema tool
        $entityManager = $this->getEntityManager();
        $schemaTool = new SchemaTool($entityManager);

        // load the class definitions
        $classes = $entityManager->getMetadataFactory()->getAllMetadata();

        // drop the schema if it already exists and create it new
        $schemaTool->dropSchema($classes);
        $schemaTool->createSchema($classes);
    }

    /**
     * Creates some default credentials to login.
     *
     * @return void
     */
    public function createDefaultCredentials()
    {

        try {
            // load the entity manager
            $entityManager = $this->getEntityManager();

            // create the default credentials
            foreach ($this->users as $userData) {
                // extract the user data
                list ($username, $email, $locale, $password, $roleNames) = $userData;

                // set user data and save it
                $user = $this->providerInterface->newInstance('\AppserverIo\Apps\Api\Entities\User');
                $user->setEmail($email);
                $user->setUsername($username);
                $user->setUserLocale($locale);
                $user->setPassword(md5($password));

                // create a collection to store the user's roles
                $roles = new ArrayCollection();

                // create the user's roles
                foreach ($roleNames as $roleName) {
                    $role = $this->providerInterface->newInstance('\AppserverIo\Apps\Api\Entities\Role');
                    $role->setUser($user);
                    $role->setName($roleName);
                    $roles->add($role);
                }

                // set the user's roles
                $user->setRoles($roles);

                // persist the user
                $entityManager->persist($user);
            }

            // flush the entity manager
            $entityManager->flush();

        } catch (\Exception $e) {
            // log the exception
            $this->getInitialContext()->getSystemLogger()->error($e->__toString());
        }
    }
}
