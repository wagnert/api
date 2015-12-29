<?php

/**
 * AppserverIo\Apps\Api\Encoding\Encoder\JmsSerializerEncoder
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

namespace AppserverIo\Apps\Api\Encoding\Encoder;

use JMS\Serializer\SerializerBuilder;
use AppserverIo\Appserver\ServletEngine\RequestHandler;
use AppserverIo\Apps\Api\TransferObject\EncodedViewData;

/**
 * A JMS Serializer based encoder implemenetation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
class JmsSerializerEncoder extends SimpleJsonEncoder implements EncoderInterface
{

    /**
     * Queries whether or not this encoder can handle the passed content.
     *
     * @param mixed $content The content to be encoded
     *
     * @return boolean TRUE if the passed content can be handled, else FALSE
     */
    public function canHandle($content)
    {
        return true;
    }

    /**
     * JSON encodes the passed content and returns it.
     *
     * @param mixed $content The content to be JSON encoded
     *
     * @return \AppserverIo\Apps\Api\TransferObject\EncodedViewData The DTO with the encoded content
     */
    public function encode($content)
    {

        // this is necessary to load the PSR-4 compatible Swagger library
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($this, 'loadClass'));

        // serialize the passed content
        return new EncodedViewData($this->getContentType(), SerializerBuilder::create()->build()->serialize($content, 'json'));
    }

    /**
     * The annotation class loader that is necessary to load the swagger
     * libraries annotation classes.
     *
     * @param string $className The name of the annotation class load
     *
     * @return boolean TRUE if the class has been loaded, else FALSE
     */
    public function loadClass($className)
    {

        // load the application instance
        $application = RequestHandler::getApplicationContext();

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
    }
}
