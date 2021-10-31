<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\App\WorkRoom\EventHandler;

use MoChat\App\WorkRoom\QueueService\UpdateCallback;
use MoChat\Framework\Annotation\WeChatEventHandler;
use MoChat\Framework\WeWork\EventHandler\AbstractEventHandler;

/**
 * 客户群修改 - 事件回调.
 * @WeChatEventHandler(eventPath="event/change_external_chat/update")
 * Class WorkRoomUpdateHandler
 */
class WorkRoomUpdateHandler extends AbstractEventHandler
{
    /**
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return null|mixed|void
     */
    public function process()
    {
        ## 队列
        (new UpdateCallback())->handle($this->message);
    }
}
