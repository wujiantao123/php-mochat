<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\App\Rbac\Action\Dashboard\Role;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\RequestMapping;
use MoChat\App\Common\Middleware\DashboardAuthMiddleware;
use MoChat\App\Rbac\Logic\Role\PermissionShowLogic;
use MoChat\App\Rbac\Middleware\PermissionMiddleware;
use MoChat\Framework\Action\AbstractAction;
use MoChat\Framework\Constants\ErrorCode;
use MoChat\Framework\Exception\CommonException;

/**
 * 角色权限显示.
 *
 * @Controller
 */
class PermissionShow extends AbstractAction
{
    /**
     * @Inject
     *
     * @var PermissionShowLogic
     */
    protected $logic;

    /**
     * @Middlewares({
     *     @Middleware(DashboardAuthMiddleware::class),
     *     @Middleware(PermissionMiddleware::class)
     * })
     * @RequestMapping(path="/dashboard/role/permissionShow", methods="GET")
     *
     * @return array 返回数组
     */
    public function handle(): array
    {
        $roleId = (int) $this->request->query('roleId', 0);
        if (! $roleId) {
            throw new CommonException(ErrorCode::INVALID_PARAMS, '角色ID必须');
        }

        return $this->logic->roleMenus($roleId);
    }
}
