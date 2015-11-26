<?php

/**
 * AppserverIo\Apps\Api\Serializer\ApplicationSerializer
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

use Tobscure\JsonApi\AbstractSerializer;

/**
 * A SLSB implementation providing the business logic to handle applications.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
class ApplicationSerializer extends AbstractSerializer
{

    /**
     * The serializer type.
     *
     * @var string
     */
    protected $type = 'applications';

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
            'name' => $model->getName(),
            'webappPath' => $model->getWebappPath()
        ];
    }
}
