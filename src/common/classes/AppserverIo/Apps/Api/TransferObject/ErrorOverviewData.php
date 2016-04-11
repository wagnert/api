<?php

/**
 * AppserverIo\Apps\Api\TransferObject\ErrorOverviewData
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

use Swagger\Annotations as SWG;
use Rhumsaa\Uuid\Uuid;

/**
 * DTO for the error overview data implementation.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @SWG\Definition(type="object")
 */
class ErrorOverviewData
{

    /**
     * The HTTP status code.
     *
     * @var integer
     * @SWG\Property(property="status", type="integer")
     */
    protected $status;

    /**
     * The error code.
     *
     * @var integer
     * @SWG\Property(property="code", type="integer")
     */
    protected $code;

    /**
     * The error source.
     *
     * @var string
     * @SWG\Property(property="source", type="\AppserverIo\Apps\Api\TransferObject\SourceViewData")
     */
    protected $source;

    /**
     * The error title.
     *
     * @var string
     * @SWG\Property(property="title", type="string")
     */
    protected $title;

    /**
     * The error detail.
     *
     * @var string
     * @SWG\Property(property="detail", type="string")
     */
    protected $detail;

    /**
     * Initializes the DTO with the passed data.
     *
     * @param \AppserverIo\Apps\Api\TransferObject\SourceViewData $source The error source
     * @param integer                                             $status The HTTP status code to use
     * @param string                                              $title  The error title
     * @param integer|null                                        $code   The error code
     * @param string|null                                         $detail The error detail
     */
    protected function __construct(SourceViewData $source, $status, $title, $code = null, $detail = null)
    {

        // initialize the mandatory members
        $this->setSource($source);
        $this->setStatus($status);
        $this->setTitle($title);

        // initialize the optional members
        if ($code) {
            $this->setCode($code);
        }
        if ($detail) {
            $this->setDetail($detail);
        }
    }

    /**
     * Factory method to create a new DTO for the passed error details.
     *
     * @param integer      $status The HTTP status code to use
     * @param string       $title  The error title
     * @param integer|null $code   The error code
     * @param string|null  $source The error source
     * @param string|null  $detail The error detail
     *
     * @return \AppserverIo\Apps\Api\TransferObject\ErrorOverviewData The initialized DTO
     */
    public static function factoryForPointer($status, $title, $code = null, $source = null, $detail = null)
    {
        return new ErrorOverviewData(new SourceViewData($source), $status, $title, $code, $detail);
    }

    /**
     * Factory method to create a new DTO for the passed error details.
     *
     * @param integer      $status The HTTP status code to use
     * @param string       $title  The error title
     * @param integer|null $code   The error code
     * @param string|null  $source The error source
     * @param string|null  $detail The error detail
     *
     * @return \AppserverIo\Apps\Api\TransferObject\ErrorOverviewData The initialized DTO
     */
    public static function factoryForParameter($status, $title, $code = null, $source = null, $detail = null)
    {
        return new ErrorOverviewData(new SourceViewData(null, $source), $status, $title, $code, $detail);
    }

    /**
     * Set's the HTTP status code.
     *
     * @param integer $status The HTTP status code
     *
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Return's the HTTP status code.
     *
     * @return integer The HTTP status code
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set's the error's code.
     *
     * @param integer $code The error's code
     *
     * @return void
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Return's the error's code.
     *
     * @return integer|null The error's code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set's the error's code.
     *
     * @param string $title The error's code
     *
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Return's the error's title.
     *
     * @return string|null The error's title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set's the error's source.
     *
     * @param \AppserverIo\Apps\Api\TransferObject\SourceViewData $source The error's source
     *
     * @return void
     */
    public function setSource(SourceViewData $source)
    {
        $this->source = $source;
    }

    /**
     * Return's the error's source.
     *
     * @return \AppserverIo\Apps\Api\TransferObject\SourceViewData The error's source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set's the error's detail.
     *
     * @param string|null $detail The error's detail
     *
     * @return void
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;
    }

    /**
     * Return's the error's detail.
     *
     * @return string|null The error's detail
     */
    public function getDetail()
    {
        return $this->detail;
    }
}
