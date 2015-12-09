<?php

/**
 * AppserverIo\Apps\Api\Dto\VirtualHost
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

namespace AppserverIo\Apps\Api\Dto;

use Swagger\Annotations as SWG;
use AppserverIo\Appserver\Core\Api\Node\VirtualHostNodeInterface;

/**
 * DTO for the virtual host data.
 *
 * @author    Tim Wagner <tw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io-apps/api
 * @link      http://www.appserver.io
 *
 * @SWG\Definition(type="object", required={"name"})
 */
class VirtualHost
{

    /**
     * The virtual host name.
     *
     * @var string
     * @SWG\Property(property="name", type="string")
     */
    protected $name;

    /**
     * Initializes the DTO with the passed virtual host node data.
     *
     * @param \AppserverIo\Appserver\Core\Api\Node\VirtualHostNodeInterface $virtualHostNode
     */
    public function __construct(VirtualHostNodeInterface $virtualHostNode)
    {
        $this->name = $virtualHostNode->getName();
    }
}