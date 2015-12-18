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
use AppserverIo\Appserver\Core\Api\Node\AppNodeInterface;

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
     * Returns the application node with the passed ID.
     *
     * @param string $id The ID of the application node to be returned
     *
     * @return \AppserverIo\Appserver\Core\Api\Node\AppNodeInterface The requested application node
     * @see \AppserverIo\Apps\Api\Service\ApplicationRepositoryInterface::load()
     */
    public function load($id)
    {
        return $this->newService(ServiceKeys::APPLICATION)->load($id);
    }

    /**
     * Returns an array with the available application nodes.
     *
     * @return array The array with the available application nodes
     * @see \AppserverIo\Apps\Api\Service\ApplicationRepositoryInterface::findAll()
     */
    public function findAll()
    {
        return $this->newService(ServiceKeys::APPLICATION)->findAll();
    }

    /**
     * Uploads the passed file to the application servers deploy directory.
     *
     * @param string $filename The filename
     *
     * @return void
     * @see \AppserverIo\Apps\Api\Service\ApplicationRepositoryInterface::upload()
     */
    public function upload($filename)
    {
        $this->newService(ServiceKeys::APPLICATION)->soak(new \SplFileInfo($filename));
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
     * @param \AppserverIo\Appserver\Core\Api\Node\AppNodeInterface $appNode The application node to return the thumbnail path for
     *
     * @return string The absolute path to the app's thumbnail
     */
    protected function getThumbnailPath(AppNodeInterface $appNode)
    {

        // prepare the thumbnail path of the passed app node
        $thumbnailPath = $appNode->getWebappPath() . DIRECTORY_SEPARATOR . 'WEB-INF' . DIRECTORY_SEPARATOR . ApplicationRepository::THUMBNAIL;

        // check if the app contains a thumbnail in it's WEB-INF folder
        if (file_exists($thumbnailPath)) {
            return $thumbnailPath;
        }

        // if not, return the placeholder thumbnail
        return $appNode->getWebappPath() . DIRECTORY_SEPARATOR . 'WEB-INF'  . DIRECTORY_SEPARATOR . ApplicationRepository::THUMBNAIL_PLACEHOLDER;
    }
}
