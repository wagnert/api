<?php

/**
 * AppserverIo\Apps\Api\TransferObject\NamingDirectoryOverviewData
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
 * DTO for the naming directory overview data implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @SWG\Definition(type="object", required={"id"})
 */
class NamingDirectoryOverviewData
{

    /**
     * The naming directory UUID.
     *
     * @var string
     * @SWG\Property(property="id", type="string")
     */
    protected $id;

    /**
     * The naming directory name.
     *
     * @var string
     * @SWG\Property(property="name", type="string")
     */
    protected $name;

    /**
     * The naming directory scheme.
     *
     * @var string
     * @SWG\Property(property="scheme", type="string")
     */
    protected $scheme;

    /**
     * Set's the naming directory's UUID.
     *
     * @param string $name The naming directory's UUID
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Return's the naming directory's UUID.
     *
     * @return string The naming directory's UUID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set's the naming directory's name.
     *
     * @param string|null $name The naming directory's name
     *
     * @return void
     */
    public function setName($name = null)
    {
        $this->name = $name;
    }

    /**
     * Return's the naming directory's name.
     *
     * @return string|null The naming directory's name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set's the naming directory's scheme.
     *
     * @param string $name|null The naming directory's scheme
     *
     * @return void
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
    }

    /**
     * Return's the naming directory's scheme.
     *
     * @return string|null The naming directory's scheme
     */
    public function getScheme()
    {
        return $this->scheme;
    }
}
