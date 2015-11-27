<?php

/**
 * AppserverIo\Apps\Api\Serializer\DatasourceSerializer
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

namespace AppserverIo\Apps\Api\Serializer;

use Tobscure\JsonApi\Resource;
use Tobscure\JsonApi\Relationship;
use Tobscure\JsonApi\AbstractSerializer;

/**
 * A SLSB implementation providing the business logic to handle datasoures.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
class DatasourceSerializer extends AbstractSerializer
{

    /**
     * The serializer type.
     *
     * @var string
     */
    protected $type = 'datasources';

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
            'name' => $model->getName()
        ];
    }

    /**
     * Returns the relationship definition for the persistence units.
     *
     * @param mixed $model The model to load the relationships from
     *
     * @param \Tobscure\JsonApi\Relationship The relationship instance
     */
    public function database($model)
    {
        return new Relationship(new Resource($model->getDatabase(), new DatabaseSerializer()));
    }

    /**
     * {@inheritDoc}
     * @see \Tobscure\JsonApi\AbstractSerializer::getId()
     */
    public function getId($model)
    {
        return $model->getName();
    }
}
