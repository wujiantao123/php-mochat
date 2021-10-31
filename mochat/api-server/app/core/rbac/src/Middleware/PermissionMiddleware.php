<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\App\Rbac\Middleware;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Utils\Context;
use MoChat\App\Common\Constants\AppErrCode;
use MoChat\App\Common\Exception\CommonException;
use MoChat\App\User\Logic\Traits\UserTrait;
use MoChat\App\Utils\Rbac\Rbac;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 权限检测.
 */
class PermissionMiddleware implements MiddlewareInterface
{
    use UserTrait;

    /**
     * @var Rbac
     */
    protected $rbac;

    /**
     * @var StdoutLoggerInterface
     */
    private $logger;

    public function __construct(ContainerInterface $container, ConfigInterface $config)
    {
        $this->rbac = $container->get(Rbac::class);
        $this->logger = $container->get(StdoutLoggerInterface::class);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $route = $request->getUri()->getPath();
            $user = user();
            $linkUrl = $route . '#' . strtolower($request->getMethod());

            ## 权限拦截
            if ($user['isSuperAdmin'] === 0 && ! $this->rbac->userCan($user['id'], $linkUrl)) {
                throw new CommonException(AppErrCode::PERMISSION_DENY);
            }

            ## 数据权限
            if ($user['isSuperAdmin']) {
                ## 超级管理员
                $routePermission['dataPermission'] = 0;
            } else {
                ## 当前路由权限
                $routePermission = $this->rbac->userPermissions($user['id'], $linkUrl, $user['corpIds'][0]);
                isset($routePermission['dataPermission']) || $routePermission['dataPermission'] = 2;
            }

            if ($routePermission['dataPermission'] === 1) {
                $deptEmployeeIds = $this->deptEmployeeIds($user['workEmployeeId']);
                empty($deptEmployeeIds) && $deptEmployeeIds[] = $user['workEmployeeId'];
            } elseif ($routePermission['dataPermission'] === 2) {
                $deptEmployeeIds = [$user['workEmployeeId']];
            } else {
                $deptEmployeeIds = [];
            }
            $request = $request->withAttribute('_user_dataPermission', $routePermission['dataPermission'])
                ->withAttribute('_user_deptEmployeeIds', $deptEmployeeIds);

            return $handler->handle(Context::set(ServerRequestInterface::class, $request));
        } catch (\Throwable $e) {
            $this->logger->error(sprintf('当前URL: %s message: %s', $request->getUri()->getPath(), $e->getMessage()));
            throw $e;
        }
    }
}
