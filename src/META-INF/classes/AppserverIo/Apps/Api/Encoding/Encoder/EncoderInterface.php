<?php

/**
 * AppserverIo\Apps\Api\Encoding\Encoder\EncoderInterface
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

/**
 * Interface for all encoder implementations.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
interface EncoderInterface
{

    /**
     * Queries whether or not this encoder can handle the passed content.
     *
     * @param mixed $content The content to be encoded
     *
     * @return boolean TRUE if the passed content can be handled, else FALSE
     */
    public function canHandle($content);

    /**
     * Encodes the passed content and returns it.
     *
     * @param mixed $content The content to be encoded
     *
     * @return \AppserverIo\Apps\Api\TransferObject\EncodedViewData The DTO with the encoded content
     */
    public function encode($content);

    /**
     * Returns the content type of the encoded content.
     *
     * @return string The content type
     */
    public function getContentType();
}
