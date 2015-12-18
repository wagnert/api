<?php

/**
 * AppserverIo\Apps\Api\Encoder\SimpleJsonEncoder
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
class SimpleJsonEncoder implements EncoderInterface
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
        return json_encode($content);
    }

    /**
     * Returns the content type of the encoded content.
     *
     * @return string The content type
     */
    public function getContentType()
    {
        return SimpleJsonEncoder::CONTENT_TYPE;
    }
}
