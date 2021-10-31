<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\App\Medium\Action\Dashboard;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\RequestMapping;
use MoChat\App\Common\Middleware\DashboardAuthMiddleware;
use MoChat\App\Medium\Action\Dashboard\Traits\RequestTrait;
use MoChat\App\Medium\Contract\MediumContract;
use MoChat\App\Rbac\Middleware\PermissionMiddleware;
use MoChat\Framework\Action\AbstractAction;
use MoChat\Framework\Constants\ErrorCode;
use MoChat\Framework\Exception\CommonException;
use MoChat\Framework\Request\ValidateSceneTrait;

/**
 * 添加 - 动作.
 * @Controller
 */
class Store extends AbstractAction
{
    use ValidateSceneTrait;
    use RequestTrait;

    /**
     * @Middlewares({
     *     @Middleware(DashboardAuthMiddleware::class),
     *     @Middleware(PermissionMiddleware::class)
     * })
     * @RequestMapping(path="/dashboard/medium/store", methods="POST")
     */
    public function handle(): array
    {
        ## 请求参数
        $params = $this->request->inputs(
            ['type', 'isSync', 'content', 'mediumGroupId'],
            ['isSync' => 1, 'mediumGroupId' => 0]
        );

        ## 验证
        $this->validated($params, 'store');

        ## 数据整理
        $userInfo = user();
        $params = array_merge($params, [
            'corp_id' => $userInfo['corpIds'][0],
            'user_id' => $userInfo['id'],
            'user_name' => $userInfo['name'],
            'content' => json_encode($params['content'], JSON_UNESCAPED_UNICODE),
        ]);

        ## 入库
        $insertId = $this->container->get(MediumContract::class)->createMedium($params);
        if (! $insertId) {
            throw new CommonException(ErrorCode::SERVER_ERROR, '素材添加失败');
        }

        return ['id' => $insertId];
    }
}
