<?php

/**
 * AppserverIo\Apps\Api\Repository\ApplicationRepository
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

use AppserverIo\Apps\Api\Utils\ServiceKeys;
use AppserverIo\Psr\Application\ApplicationInterface;

/**
 * A SLSB implementation providing the business logic to handle applications.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class ApplicationRepository extends AbstractRepository implements ApplicationRepositoryInterface
{

    /**
     * The thumbnail image name.
     *
     * @var string
     */
    const THUMBNAIL = 'app-thumbnail.png';

    /**
     * The thumbnail placeholder image name.
     *
     * @var string
     */
    const THUMBNAIL_PLACEHOLDER = 'app-placeholder-300x200.png';

    /**
     * Returns the application with the passed ID.
     *
     * @param string $id The ID of the application to be returned
     *
     * @return \AppserverIo\Psr\Application\ApplicationInterface The requested application
     * @see \AppserverIo\Apps\Api\Service\ApplicationRepositoryInterface::load()
     */
    public function load($id)
    {
        return $this->getNamingDirectory()->search(sprintf('php:global/%s/env/ApplicationInterface', $id));
    }

    /**
     * Returns an array with the available applications.
     *
     * @return array The array with the available applications
     * @see \AppserverIo\Apps\Api\Service\ApplicationRepositoryInterface::findAll()
     */
    public function findAll()
    {

        // create a local naming directory instance
        $namingDirectory = $this->getNamingDirectory();

        // initialize the array for the applications
        $applications = array();

        // convert the application nodes into stdClass representation
        foreach ($namingDirectory->search('php:global')->getAllKeys() as $key) {
            try {
                // try to load the application
                $value = $namingDirectory->search(sprintf('php:global/%s/env/ApplicationInterface', $key));

                // query whether we've found an application instance or not
                if ($value instanceof ApplicationInterface) {
                    $applications[] = $value;
                }

            } catch (\Exception $e) {
                // do nothing here, because
            }
        }

        // return the applications
        return $applications;
    }

    /**
     * Uploads the passed file to the application servers deploy directory.
     *
     * @param string $filename The filename
     * @param string $data     The file data
     *
     * @return void
     * @see \AppserverIo\Apps\Api\Service\ApplicationRepositoryInterface::upload()
     */
    public function upload($filename, $data)
    {

        // prepare service instance
        $service = $this->newService(ServiceKeys::APPLICATION);

        // prepare the upload target in the deploy directory
        $target = $service->getTmpDir() . DIRECTORY_SEPARATOR . $filename;

        // save the uploaded file in the tmp directory
        file_put_contents($target, $data);

        // let the service soak the application archive
        $service->soak(new \SplFileInfo($target));
    }

    /**
     * Deletes the app node with the passed ID from the system configuration.
     *
     * @param string $id The ID of the app node to delete
     *
     * @return void
     * @see \AppserverIo\Apps\Api\Service\ApplicationRepositoryInterface::delete()
     */
    public function delete($id)
    {
        $this->newService(ServiceKeys::APPLICATION)->undeploy($id);
    }

    /**
     * Returns the path to the thumbnail image of the app with the
     * passed ID.
     *
     * @param string $id ID of the app to return the thumbnail for
     *
     * @return string The absolute path the thumbnail
     * @see \AppserverIo\Apps\Api\Service\ApplicationRepositoryInterface::thumbnail()
     */
    public function thumbnail($id)
    {
        return $this->getThumbnailPath($this->load($id));
    }

    /**
     * Returns the full path to the application's thumbnail.
     *
     * @param \AppserverIo\Psr\Application\ApplicationInterface $application The application to return the thumbnail path for
     *
     * @return string The absolute path to the app's thumbnail
     */
    protected function getThumbnailPath(ApplicationInterface $application)
    {

        // prepare the thumbnail path of the passed app node
        $thumbnailPath = $application->getWebappPath() . DIRECTORY_SEPARATOR . 'WEB-INF' . DIRECTORY_SEPARATOR . ApplicationRepository::THUMBNAIL;

        // check if the app contains a thumbnail in it's WEB-INF folder
        if (file_exists($thumbnailPath)) {
            return $thumbnailPath;
        }

        // if not, return the placeholder thumbnail
        return $application->getWebappPath() . DIRECTORY_SEPARATOR . 'WEB-INF'  . DIRECTORY_SEPARATOR . ApplicationRepository::THUMBNAIL_PLACEHOLDER;
    }
}
