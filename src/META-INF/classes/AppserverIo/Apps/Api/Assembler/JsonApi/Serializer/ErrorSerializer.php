<?php

/**
 * AppserverIo\Apps\Api\Assembler\JsonApi\Serializer\ErrorSerializer
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
 * A JSON-API serializer for the errors.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
class ErrorSerializer extends AbstractSerializer
{

    /**
     * The serializer type.
     *
     * @var string
     */
    protected $type = 'errors';

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
            'code' => $model->getCode(),
            'source' => $model->getSource(),
            'title' => $model->getTitle(),
            'detail' => $model->getDetail()
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
