<?php

/**
 * AppserverIo\Apps\Api\Encoding\EncodingHandler
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

namespace AppserverIo\Apps\Api\Encoding;

use AppserverIo\Collections\ArrayList;
use AppserverIo\Apps\Api\Encoding\Encoder\SimpleJsonEncoder;
use AppserverIo\Apps\Api\Encoding\Encoder\JmsSerializerEncoder;

/**
 * A SLSB implementation providing the business logic to encode data.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @Stateless
 */
class EncodingHandler implements EncodingHandlerInterface
{

    /**
     * The collection with the available encoders.
     *
     * @var \AppserverIo\Collections\ArrayList
     */
    protected $encoders = null;

    /**
     * Initializes the handler with the available encoders.
     */
    public function __construct()
    {

        // the array list with the availalbe encoders
        $this->encoders = new ArrayList();

        // add the available encodees
        $this->encoders->add(new SimpleJsonEncoder());
        $this->encoders->add(new JmsSerializerEncoder());
    }

    /**
     * Encodes the passed content and returns it.
     *
     * @param mixed $content The content to be encoded
     *
     * @return \AppserverIo\Apps\Api\TransferObject\EncodedViewData The DTO with the encoded content
     * @see \AppserverIo\Apps\Example\Encoding\EncodingHandlerInterface::encode()
     */
    public function encode($content)
    {
        foreach ($this->encoders as $encoder) {
            if ($encoder->canHandle($content)) {
                return $encoder->encode($content);
            }
        }
    }
}
