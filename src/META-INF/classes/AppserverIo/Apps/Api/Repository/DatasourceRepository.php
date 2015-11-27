<?php

/**
 * AppserverIo\Apps\Api\Repository\DatasourceRepository
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

namespace AppserverIo\Apps\Api\Repository;

/**
 * A SLSB implementation providing the business logic to handle datasource nodes.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class DatasourceRepository extends AbstractRepository implements DatasourceRepositoryInterface
{

    /**
     * Returns the datasource node with the passed ID.
     *
     * @param string $id The ID of the datasource node to be returned
     *
     * @return \AppserverIo\Appserver\Core\Api\DatasourceNodeInterface The requested datasource node
     * @see \AppserverIo\Apps\Api\Service\DatasourceRepositoryInterface::load()
     */
    public function load($id)
    {
        return $this->getNamingDirectory()->search(sprintf('php:env/%s', $id));
    }

    /**
     * Returns an array with the available datasource nodes.
     *
     * @return array The array with the available datasource nodes
     * @see \AppserverIo\Apps\Api\Service\DatasourceRepositoryInterface::findAll()
     */
    public function findAll()
    {

        // create a local naming directory instance
        $namingDirectory = $this->getNamingDirectory();

        // initialize the array with the datasources
        $datasourceNodes = array();

        // convert the application nodes into stdClass representation
        foreach ($namingDirectory->search('php:env')->getAllKeys() as $key) {
            try {
                // try to load the datasource itself
                $val = $namingDirectory->search(sprintf('php:env/%s/ds', $key));

                if ($val instanceof NamingDirectoryInterface) {

                    // try to load the application
                    foreach ($val->getAllKeys() as $dsKey) {

                        // try to load the datasource
                        $value = $namingDirectory->search(sprintf('php:env/%s/ds/%s', $key, $dsKey));

                        // query whether we've found a datasource instance or not
                        if ($value instanceof DatasourceNode) {
                            $datasourceNodes[] = $value;
                        }
                    }
                }

            } catch (\Exception $e) {
                // do nothing here, because
            }
        }

        // return the datasource nodes
        return $datasourceNodes;
    }
}
