<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\App\WorkContact\Action\Sidebar;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;
use Hyperf\HttpServer\Annotation\RequestMapping;
use MoChat\App\Common\Middleware\SidebarAuthMiddleware;
use MoChat\App\WorkContact\Contract\ContactEmployeeTrackContract;
use MoChat\Framework\Action\AbstractAction;
use MoChat\Framework\Request\ValidateSceneTrait;

/**
 * 互动轨迹.
 *
 * Class Track
 * @Controller
 */
class Track extends AbstractAction
{
    use ValidateSceneTrait;

    /**
     * 互动轨迹表.
     * @Inject
     * @var ContactEmployeeTrackContract
     */
    private $track;

    /**
     * @Middlewares({
     *     @Middleware(SidebarAuthMiddleware::class)
     * })
     * @RequestMapping(path="/sidebar/workContact/track", methods="GET")
     */
    public function handle()
    {
        //接收参数
        $params['contactId'] = $this->request->input('contactId');
        //校验参数
        $this->validated($params);

        $columns = [
            'id',
            'content',
            'created_at',
        ];
        return $this->track->getContactEmployeeTracksByContactId((int) $params['contactId'], $columns);
    }

    /**
     * @return string[] 规则
     */
    public function rules(): array
    {
        return [
            'contactId' => 'required|integer|min:1|bail',
        ];
    }

    /**
     * 获取已定义验证规则的错误消息.
     */
    public function messages(): array
    {
        return [
            'contactId.required' => '客户id必传',
        ];
    }
}
