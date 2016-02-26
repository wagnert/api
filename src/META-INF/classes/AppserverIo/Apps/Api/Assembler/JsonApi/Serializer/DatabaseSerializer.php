<?php

/**
 * AppserverIo\Apps\Api\Assembler\JsonApi\Serializer\DatabaseSerializer
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

namespace AppserverIo\Apps\Api\Assembler\JsonApi\Serializer;

use Tobscure\JsonApi\AbstractSerializer;

/**
 * A SLSB implementation providing the business logic to handle databases.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
class DatabaseSerializer extends AbstractSerializer
{

    /**
     * The serializer type.
     *
     * @var string
     */
    protected $type = 'databases';

    /**
     * Get the attributes array.
     *
     * @param mixed      $model  The model the attributes has to be serialized
     * @param array|null $fields The fields that has to be serialized
     *
     * @return array The array with the attributes
     * @see \Tobscure\JsonApi\AbstractSerializer::getAttributes()
     */
    public function getAttributes($model, array $fields = null)
    {
        return [
            'charset' => $model->getCharset(),
            'databaseHost' => $model->getDatabaseHost(),
            'databaseName' => $model->getDatabaseName(),
            'databasePort' => $model->getDatabasePort(),
            'driver' => $model->getDriver(),
            'driverOptions' => $model->getDriverOptions(),
            'memory' => $model->getMemory(),
            'password' => $model->getPassword(),
            'path' => $model->getPath(),
            'unixSocket' => $model->getUnixSocket(),
            'user' => $model->getUser()
        ];
    }

    /**
     * {@inheritDoc}
     * @see \Tobscure\JsonApi\AbstractSerializer::getId()
     */
    public function getId($model)
    {
        return $model->getId();
    }
}
