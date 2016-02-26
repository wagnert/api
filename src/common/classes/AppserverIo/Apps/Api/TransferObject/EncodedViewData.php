<?php

/**
 * AppserverIo\Apps\Api\TransferObject\EncodedViewData
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

namespace AppserverIo\Apps\Api\TransferObject;

/**
 * DTO for the encoded view data implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 */
class EncodedViewData
{

    /**
     * The content type of the encoded data.
     *
     * @var string
     */
    protected $contentType;

    /**
     * The encoded data itself.
     *
     * @var string
     */
    protected $data;

    /**
     * Initializes the DTO with the passed data.
     *
     * @param string $contentType The content type of the encoded data
     * @param string $data        The encoded data itself
     */
    public function __construct($contentType, $data)
    {
        $this->setContentType($contentType);
        $this->setData($data);
    }

    /**
     * Set's the content type of the encoded data.
     *
     * @param string $contentType The content type
     *
     * @return void
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * Return's the content type of the encoded data.
     *
     * @return string The content type
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set's the encoded data itself.
     *
     * @param string $data The encoded data
     *
     * @return void
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Return's the encoded data itself.
     *
     * @return string The encoded data
     */
    public function getData()
    {
        return $this->data;
    }
}
