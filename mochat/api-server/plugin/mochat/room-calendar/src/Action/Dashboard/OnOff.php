<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\Plugin\RoomCalendar\Action\Dashboard;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use MoChat\App\Common\Middleware\DashboardAuthMiddleware;
use MoChat\App\Rbac\Middleware\PermissionMiddleware;
use MoChat\Framework\Constants\ErrorCode;
use MoChat\Framework\Exception\CommonException;
use MoChat\Framework\Request\ValidateSceneTrait;
use MoChat\Plugin\RoomCalendar\Contract\RoomCalendarContract;
use MoChat\Plugin\RoomCalendar\Contract\RoomCalendarPushContract;
use Psr\Container\ContainerInterface;

/**
 * 群日历- 开关.
 * @Controller
 */
class OnOff
{
    use ValidateSceneTrait;

    /**
     * @Inject
     * @var RoomCalendarContract
     */
    protected $roomCalendarService;

    /**
     * @Inject
     * @var RoomCalendarPushContract
     */
    protected $roomCalendarPushService;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var StdoutLoggerInterface
     */
    protected $logger;

    public function __construct(RequestInterface $request, ContainerInterface $container)
    {
        $this->request = $request;
        $this->container = $container;
    }

    /**
     * @Middlewares({
     *     @Middleware(DashboardAuthMiddleware::class),
     *     @Middleware(PermissionMiddleware::class)
     * })
     * @RequestMapping(path="/dashboard/roomCalendar/onOff", methods="put")
     */
    public function handle(): array
    {
        ## 验证接受参数
        $this->validated($this->request->all(), 'update');
        $params = $this->request->all();
        ## 获取当前登录用户
        $user = user();

        ## 判断用户绑定企业信息
        if (! isset($user['corpIds']) || count($user['corpIds']) != 1) {
            throw new CommonException(ErrorCode::INVALID_PARAMS, '未选择登录企业，不可操作');
        }

        ## 数据操作
        Db::beginTransaction();
        try {
            $this->roomCalendarService->updateRoomCalendarById((int) $params['id'], ['on_off' => $params['on_off']]);
            $this->roomCalendarPushService->updateRoomCalendarPushByByRoomCalendarId((int) $params['id'], ['on_off' => $params['on_off']]);
            Db::commit();
        } catch (\Throwable $e) {
            Db::rollBack();
            $loggers = $this->container->get(StdoutLoggerInterface::class);
            $loggers->error(sprintf('%s [%s] %s', '群日历修改开关失败', date('Y-m-d H:i:s'), $e->getMessage()));
            $loggers->error($e->getTraceAsString());
            throw new CommonException(ErrorCode::SERVER_ERROR, '群日历修改开关失败'); //$e->getMessage()
        }

        return [];
    }

    /**
     * 验证规则.
     *
     * @return array 响应数据
     */
    protected function rules(): array
    {
        return [
            'id' => 'required | integer | bail',
            'on_off' => 'required',
        ];
    }

    /**
     * 验证错误提示.
     * @return array 响应数据
     */
    protected function messages(): array
    {
        return [
            'id.required' => '活动id 必填',
            'id.integer' => '活动id 必须为整型',
            'on_off' => '开关 必填',
        ];
    }
}
