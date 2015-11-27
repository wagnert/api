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

use AppserverIo\Psr\Servlet\Http\HttpServlet;
use AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface;
use AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface;
use AppserverIo\Server\Dictionaries\MimeTypes;
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
class ThumbnailServlet extends HttpServlet
{

    /**
     * The ApplicationProcessor instance.
     *
     * @var \AppserverIo\Apps\Api\Services\ApplicationProcessor
     * @EnterpriseBean
     */
    protected $applicationProcessor;

    /**
     * Tries to load the requested thumbnail from the applications WEB-INF directory
     * and adds it to the response.
     *
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletRequestInterface  $servletRequest  The request instance
     * @param \AppserverIo\Psr\Servlet\Http\HttpServletResponseInterface $servletResponse The response instance
     *
     * @return void
     * @see \AppserverIo\Psr\Servlet\Http\HttpServlet::doGet()
     *
     * @SWG\Get(
     *   path="/thumbnails.do",
     *   summary="The application's thumbnail",
     *   @SWG\Response(
     *     response=200,
     *     description="The application's thumbnail"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function doGet(HttpServletRequestInterface $servletRequest, HttpServletResponseInterface $servletResponse)
    {

        // load the requested path info, e. g. /api/thumbnails.do/example/
        $pathInfo = trim($servletRequest->getPathInfo(), '/');

        // extract the entity and the ID, if available
        list ($id, ) = explode('/', $pathInfo);

        // load file information and return the file object if possible
        $fileInfo = new \SplFileInfo($path = $this->applicationProcessor->thumbnail($id));
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
