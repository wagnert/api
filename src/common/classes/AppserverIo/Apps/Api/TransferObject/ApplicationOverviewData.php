<?php

/**
 * AppserverIo\Apps\Api\TransferObject\ApplicationOverviewData
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

namespace AppserverIo\Apps\Api\TransferObject;

use Swagger\Annotations as SWG;

/**
 * DTO for the application overview data implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @SWG\Definition(type="object", required={"id", "name", "webappPath"})
 */
class ApplicationOverviewData
{

    /**
     * The virtual host UUID.
     *
     * @var string
     * @SWG\Property(property="id", type="string")
     */
    protected $id;


    /**
     * The application name.
     *
     * @var string
     * @SWG\Property(property="name", type="string")
     */
    protected $name;

    /**
     * The application webapp path.
     *
     * @var string
     * @SWG\Property(property="webappPath", type="string")
     */
    protected $webappPath;

    /**
     * Set's the application's UUID.
     *
     * @param string $name The application's UUID
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Return's the application's UUID.
     *
     * @return string The application's UUID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set's the application's name.
     *
     * @param string $name The application's name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Return's the application's name.
     *
     * @return string The application's name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set's the application's webapp path.
     *
     * @param string $webappPath The applications webapp path
     *
     * @return void
     */
    public function setWebappPath($webappPath)
    {
        $this->webappPath = $webappPath;
    }

    /**
     * Return's the application's webapp path.
     *
     * @return string The application's webapp path
     */
    public function getWebappPath()
    {
        return $this->webappPath;
    }
}
