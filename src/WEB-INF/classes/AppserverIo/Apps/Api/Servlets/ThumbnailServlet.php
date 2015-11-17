<?php

/**
 * AppserverIo\Apps\Api\Servlets\ThumbnailServlet
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
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Apps\Api\Servlets;

use AppserverIo\Psr\Servlet\ServletConfig;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;
use AppserverIo\WebServer\Dictionaries\MimeTypes;
use AppserverIo\Apps\Api\Service\AppService;
use AppserverIo\Apps\Api\Servlets\AbstractServlet;
use AppserverIo\Apps\Api\Exceptions\FileNotFoundException;
use AppserverIo\Apps\Api\Exceptions\FileNotReadableException;
use AppserverIo\Apps\Api\Exceptions\FoundDirInsteadOfFileException;

/**
 * Servlet that handles all thumbnail related requests.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/appserver
 * @link      http://www.appserver.io
 */
class ThumbnailServlet extends AbstractServlet
{

    /**
     * The service class name to use.
     *
     * @var string
     */
    const SERVICE_CLASS = '\AppserverIo\Apps\Api\Service\AppService';

    /**
     * Returns the servlets service class to use.
     *
     * @return string The servlets service class
     */
    public function getServiceClass()
    {
        return ThumbnailServlet::SERVICE_CLASS;
    }

    /**
     * Tries to load the requested thumbnail from the applications WEB-INF directory
     * and adds it to the response.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doGet()
     */
    public function doGet(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // explode the URI
        $uri = trim($servletRequest->getUri(), '/');
        list ($applicationName, $entity, $id) = explode('/', $uri, 3);

        // set the base URL for rendering images/thumbnails
        $this->getService($servletRequest)->setBaseUrl($this->getBaseUrl($servletRequest));
        $this->getService($servletRequest)->setWebappPath($servletRequest->getContext()->getWebappPath());

        // load file information and return the file object if possible
        $fileInfo = new \SplFileInfo($path = $this->getService($servletRequest)->thumbnail($id));
        if ($fileInfo->isDir()) {
            throw new FoundDirInsteadOfFileException(sprintf("Requested file %s is a directory", $path));
        }
        if ($fileInfo->isFile() === false) {
            throw new FileNotFoundException(sprintf('File %s not not found', $path));
        }
        if ($fileInfo->isReadable() === false) {
            throw new FileNotReadableException(sprintf('File %s is not readable', $path));
        }

        // open the file itself
        $file = $fileInfo->openFile();

        // set mimetypes to header
        $servletResponse->addHeader(
            'Content-Type',
            MimeTypes::getMimeTypeByExtension(
                pathinfo(
                    $file->getFilename(),
                    PATHINFO_EXTENSION
                )
            )
        );

        // set last modified date from file
        $servletResponse->addHeader('Last-Modified', gmdate('D, d M Y H:i:s \G\M\T', $file->getMTime()));

        // set expires date
        $servletResponse->addHeader('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 3600));

        // check if If-Modified-Since header info is set
        if ($servletRequest->getHeader('If-Modified-Since')) {
            // check if file is modified since header given header date
            if (strtotime($servletRequest->getHeader('If-Modified-Since')) >= $file->getMTime()) {
                // send 304 Not Modified Header information without content
                $servletResponse->addHeader('status', 'HTTP/1.1 304 Not Modified');
                $servletResponse->appendBodyStream(PHP_EOL);
                return;
            }
        }

        // add the thumbnail as response content
        $servletResponse->appendBodyStream(file_get_contents($file->getRealPath()));
    }
}
