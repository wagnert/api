<?php

/**
 * AppserverIo\Apps\Example\Repository\ApplicationRepositoryInterface
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
 * An interface for SLSB implementations providing the business logic
 * to handle applications.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
interface ApplicationRepositoryInterface
{

    /**
     * Returns the application with the passed ID.
     *
     * @param string $id The ID of the application to be returned
     *
     * @return \AppserverIo\Psr\Application\ApplicationInterface The requested application
     */
    public function load($id);

    /**
     * Returns an array with the available applications.
     *
     * @return array The array with the available applications
     */
    public function findAll();

    /**
     * Uploads the passed file to the application servers deploy directory.
     *
     * @param string $filename The filename
     * @param string $data     The file data
     *
     * @return void
     */
    public function upload($filename, $data);

    /**
     * Deletes the app node with the passed ID from the system configuration.
     *
     * @param string $id The ID of the app node to delete
     *
     * @return void
     */
    public function delete($id);

    /**
     * Returns the path to the thumbnail image of the app with the
     * passed ID.
     *
     * @param string $id ID of the app to return the thumbnail for
     *
     * @return string The absolute path the thumbnail
     */
    public function thumbnail($id);
}
