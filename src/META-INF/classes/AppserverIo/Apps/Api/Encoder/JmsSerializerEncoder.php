<?php

/**
 * AppserverIo\Apps\Api\Encoder\JmsSerializerEncoder
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

namespace AppserverIo\Apps\Api\Encoder;

use AppserverIo\Http\HttpProtocol;
use JMS\Serializer\SerializerBuilder;
use AppserverIo\Appserver\ServletEngine\RequestHandler;

/**
 * A simple JSON encoder implemenetation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class JmsSerializerEncoder implements EncoderInterface
{

    /**
     * The content type of the encoded content.
     *
     * @var string
     */
    const CONTENT_TYPE = 'application/json';

    /**
     * JSON encodes the passed content and returns it.
     *
     * @param mixed $content The content to be JSON encoded
     *
     * @return string The encoded content
     */
    public function encode($content)
    {

        // load the application context
        $application = RequestHandler::getApplicationContext();

        // this is necessary to load the PSR-4 compatible Swagger library
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(function($className) use ($application) {

            // load the application directory
            $webappPath = $application->getWebappPath();
            $shortName = str_replace("Swagger\\Annotations\\", DIRECTORY_SEPARATOR, $className);

            // prepare the annotation filename for the Swagger annotations
            $file = sprintf('%s/vendor/zircote/swagger-php/src/Annotations/%s.php', $webappPath, $shortName);

            // query whether the file exists or not
            if (file_exists($file)) {
                require $file;
                return class_exists($className);
            }

            // return FALSE if the class can't be loaded
            return false;
        });

        // create the builder instance
        $builder = SerializerBuilder::create();

        // configure/register the handler for the JSON-API documents
        $builder->configureHandlers(function(JMS\Serializer\Handler\HandlerRegistry $registry) {
            $registry->registerHandler('serialization', 'Tobscure\JsonApi\Document', 'json',
                function($visitor, Tobscure\JsonApi\Document $obj, array $type) {
                    return $obj->__toString();
                }
            );
        });

        // serialize the content
        return $builder->build()->serialize($content, 'json');
    }

    /**
     * Returns the content type of the encoded content.
     *
     * @return string The content type
     */
    public function getContentType()
    {
        return JmsSerializerEncoder::CONTENT_TYPE;
    }
}
