<?php

/**
 * AppserverIo\Apps\Api\Encoding\Encoder\SimpleJsonEncoder
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

use AppserverIo\Apps\Api\TransferObject\EncodedViewData;

/**
 * A simple JSON encoder implemenetation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
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
     * Queries whether or not this encoder can handle the passed content.
     *
     * @param mixed $content The content to be encoded
     *
     * @return boolean TRUE if the passed content can be handled, else FALSE
     */
    public function canHandle($content)
    {
        return $content instanceof \JsonSerializable;
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
        return new EncodedViewData($this->getContentType(), json_encode($content));
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
