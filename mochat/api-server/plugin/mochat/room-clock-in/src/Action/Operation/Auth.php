<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\Plugin\RoomClockIn\Action\Operation;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Session\Middleware\SessionMiddleware;
use MoChat\App\OfficialAccount\Action\Operation\Traits\AuthTrait;
use MoChat\Framework\Action\AbstractAction;
use MoChat\Framework\Constants\ErrorCode;
use MoChat\Framework\Exception\CommonException;
use MoChat\Framework\Request\ValidateSceneTrait;
use MoChat\Plugin\RoomClockIn\Contract\ClockInContract;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;

/**
 * 公众号授权跳转.
 * @Controller
 */
class Auth extends AbstractAction
{
    use AuthTrait;
    use ValidateSceneTrait;

    /**
     * @Inject
     * @var ClockInContract
     */
    protected $clockInService;

    /**
     * 为了自动兼容nginx转发规则，此处的路由定义与规范不同.
     *
     * @Middleware(SessionMiddleware::class)
     * @RequestMapping(path="/operation/auth/roomClockIn", methods="get,post")
     */
    public function handle(): Psr7ResponseInterface
    {
        $this->validated($this->request->all());
        return $this->execute();
    }

    /**
     * 验证规则.
     *
     * @return array 响应数据
     */
    protected function rules(): array
    {
        return [
            'target' => 'required',
        ];
    }

    /**
     * 验证错误提示.
     * @return array 响应数据
     */
    protected function messages(): array
    {
        return [
            'target.required' => 'target 必传',
        ];
    }

    protected function getModuleName()
    {
        return 'roomClockIn';
    }

    protected function getType(): int
    {
        return 1;
    }

    protected function getCorpId(): int
    {
        $id = (int) $this->request->input('id');

        if ($id === 0) {
            throw new CommonException(ErrorCode::INVALID_PARAMS, '数据不存在');
        }

        $info = $this->clockInService->getClockInById($id, ['corp_id']);
        return empty($info) ? 0 : $info['corpId'];
    }
}
