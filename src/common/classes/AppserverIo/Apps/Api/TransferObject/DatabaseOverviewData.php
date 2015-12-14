<?php

/**
 * AppserverIo\Apps\Api\TransferObject\DatabaseOverviewData
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
 * DTO for the database overview data implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @SWG\Definition(type="object", required={"id", "driver"})
 */
class DatabaseOverviewData
{

    /**
     * The database UUID.
     *
     * @var string
     * @SWG\Property(property="id", type="string")
     */
    protected $id;

    /**
     * The database driver information.
     *
     * @var string
     * @SWG\Property(property="driver", type="string")
     */
    protected $driver;

    /**
     * The database user information.
     *
     * @var string
     * @SWG\Property(property="user", type="string")
     */
    protected $user;

    /**
     * The database password information.
     *
     * @var string
     * @SWG\Property(property="password", type="string")
     */
    protected $password;

    /**
     * The database name information.
     *
     * @var string
     * @SWG\Property(property="databaseName", type="string")
     */
    protected $databaseName;

    /**
     * The database path information (when using sqlite for example).
     *
     * @var string
     * @SWG\Property(property="path", type="string")
     */
    protected $path;

    /**
     * The flag to run Sqlite in memory (mutually exclusive with the path option).
     *
     * @var boolean
     * @SWG\Property(property="memory", type="boolean")
     */
    protected $memory;

    /**
     * The database host information.
     *
     * @var string
     * @SWG\Property(property="databaseHost", type="string")
     */
    protected $databaseHost;

    /**
     * The database port information.
     *
     * @var integer
     * @SWG\Property(property="databasePort", type="integer")
     */
    protected $databasePort;

    /**
     * The database charset information.
     *
     * @var string
     * @SWG\Property(property="string", type="string")
     */
    protected $charset;

    /**
     * The database driver options.
     *
     * @var string
     * @SWG\Property(property="driverOptions", type="string")
     */
    protected $driverOptions;

    /**
     * The name of the socket used to connect to the database.
     *
     * @var string
     * @SWG\Property(property="unixSocket", type="string")
     */
    protected $unixSocket;

    /**
     * Set's the database's UUID.
     *
     * @param string $name The database's UUID
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Return's the database's UUID.
     *
     * @return string The database's UUID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set's the database driver information.
     *
     * @param string $driver The database driver information
     *
     * @return void
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;
    }

    /**
     * Return's the database driver information.
     *
     * @return string The database driver information
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Set's the database user information.
     *
     * @param string|null $user The database user information
     *
     * @return void
     */
    public function setUser($user = null)
    {
        $this->user = $user;
    }

    /**
     * Return's the database user information.
     *
     * @return string|null The database user information
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set's the database password information.
     *
     * @param string|null $user The database password information
     *
     * @return void
     */
    public function setPassword($password = null)
    {
        $this->password = $password;
    }

    /**
     * Return's the database password information.
     *
     * @return string|null The database password information
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set's the database name information.
     *
     * @param string|null $databaseName The database name information
     *
     * @return void
     */
    public function setDatabaseName($databaseName = null)
    {
        $this->databaseName = $databaseName;
    }

    /**
     * Return's the database name information.
     *
     * @return string|null The database name information
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    /**
     * Set's the database path information (when using sqlite for example).
     *
     * @param string|null $path The database path information
     *
     * @return void
     */
    public function setPath($path = null)
    {
        $this->path = $path;
    }

    /**
     * Return's the database path information (when using sqlite for example).
     *
     * @return string|null The database path information
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set's the flag to run Sqlite in memory (mutually exclusive with the path option).
     *
     * @param boolean $memory The flag to run Sqlite in memory
     *
     * @return void
     */
    public function setMemory($memory = false)
    {
        $this->memory = $memory;
    }

    /**
     * Return's the flag to run Sqlite in memory (mutually exclusive with the path option).
     *
     * @return boolean The flag to run Sqlite in memory
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * Set's the database host information.
     *
     * @param string|null $databaseHost The database host information
     *
     * @return void
     */
    public function setDatabaseHost($databaseHost = null)
    {
        $this->databaseHost = $databaseHost;
    }

    /**
     * Return's the database host information.
     *
     * @return string|null The database host information
     */
    public function getDatabaseHost()
    {
        return $this->databaseHost;
    }

    /**
     * Set's the database port information.
     *
     * @param integer|null $databasePort The database port information
     *
     * @return void
     */
    public function setDatabasePort($databasePort = null)
    {
        $this->databasePort = $databasePort;
    }

    /**
     * Return's the database port information.
     *
     * @return integer|null The database port information
     */
    public function getDatabasePort()
    {
        return $this->databasePort;
    }

    /**
     * Set's the database charset to use.
     *
     * @param string|null $charset The database charset
     *
     * @return void
     */
    public function setCharset($charset = null)
    {
        $this->charset = $charset;
    }

    /**
     * Return's the database charset to use.
     *
     * @return string|null The database charset
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Set's the database driver options.
     *
     * @param string|null $driverOptions The database driver options
     *
     * @return void
     */
    public function setDriverOptions($driverOptions = null)
    {
        $this->driverOptions = $driverOptions;
    }

    /**
     * Return's the database driver options.
     *
     * @return string|null The database driver options
     */
    public function getDriverOptions()
    {
        return $this->driverOptions;
    }

    /**
     * Set's the name of the socket used to connect to the database.
     *
     * @param string|null $unixSocket The name of the socket
     *
     * @return void
     */
    public function setUnixSocket($unixSocket = null)
    {
        $this->unixSocket = $unixSocket;
    }

    /**
     * Return's the name of the socket used to connect to the database.
     *
     * @return string|null The name of the socket
     */
    public function getUnixSocket()
    {
        return $this->unixSocket;
    }
}
