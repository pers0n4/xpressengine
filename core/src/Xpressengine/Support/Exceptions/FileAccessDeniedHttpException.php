<?php
/**
 *  AccessDeniedHttpException Class
 *
 * PHP version 7
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support\Exceptions;

/**
 * FileAccessDeniedHttpException
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class FileAccessDeniedHttpException extends HttpXpressengineException
{
    /**
     * @var string $message exception message
     */
    protected $message = 'xe::notHavePermissionToEditFile';

    /**
     * @var int $statusCode exception http code
     */
    protected $statusCode = 403;
}
