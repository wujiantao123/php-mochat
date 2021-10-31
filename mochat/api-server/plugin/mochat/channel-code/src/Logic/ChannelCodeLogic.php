<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\Plugin\ChannelCode\Logic;

use Hyperf\Di\Annotation\Inject;
use MoChat\Plugin\ChannelCode\Contract\ChannelCodeContract;
use MoChat\Plugin\ChannelCode\Logic\Traits\ChannelCodeTrait;

/**
 * 处理渠道码脚本逻辑.
 *
 * Class ChannelCodeLogic
 */
class ChannelCodeLogic
{
    use ChannelCodeTrait;

    /**
     * 渠道码表.
     * @Inject
     * @var ChannelCodeContract
     */
    private $channelCode;

    /**
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return array|void
     */
    public function handle()
    {
        //查询所有渠道码
        $info = $this->channelCode->getChannelCodes();
        if (empty($info)) {
            return;
        }

        foreach ($info as &$value) {
            $drainageEmployee = json_decode($value['drainageEmployee'], true);

            //更新二维码
            $this->handleQrCode(
                $drainageEmployee,
                (int) $value['autoAddFriend'],
                (int) $value['corpId'],
                (int) $value['id'],
                $value['wxConfigId']
            );
        }
        unset($value);
    }
}
